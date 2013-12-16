<?php
use Phalcon\Mvc\View;
require "../app/services/Translation.php";

class LoginController extends Phalcon\Mvc\Controller {
    public function microsoftAction() {
        require('../vendor/http.php');
        require('../vendor/oauth_client.php');
        $config = include '../app/config/config.php';

        $client = new oauth_client_class;
        $client->server = $config->microsoft->server;
        $client->debug = $config->microsoft->debug;
        $client->debug_http = $config->microsoft->debugHttp;
        $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'] .
        dirname(strtok($_SERVER['REQUEST_URI'],'?')) . "/microsoft";

        $client->client_id = $config->microsoft->clientId;
        $client->client_secret = $config->microsoft->clientSecret;

        $client->scope = $config->microsoft->scope;

        if(($success = $client->Initialize())) {
            if(($success = $client->Process())) {
                if(strlen($client->authorization_error)) {
                    $client->error = $client->authorization_error;
                    $success = false;
                } elseif(strlen($client->access_token)) {
                    $success = $client->CallAPI(
                        $config->microsoft->api,
                        'GET', array(), array('FailOnAccessError'=>true), $user);
                }
            }
            $success = $client->Finalize($success);
        }

        if($client->exit) { exit; }

        if($success) {
            $schoolUser = User::findFirstByEmail($user->emails->preferred);

            if(!$schoolUser) {
                $schoolUser = new User();
                $schoolUser->schoolId = 1;
                $schoolUser->type = User::getTypeStudent();
                $schoolUser->name = $user->first_name;
                $schoolUser->lastName = $user->last_name;
                $schoolUser->password = "084e0343a0486ff05530df6c705c8bb4";
                $schoolUser->email = $user->emails->preferred;

                $schoolUser->save();
            }

            Authenticate::authenticationMicrosoft($schoolUser);
            return $this->response->redirect("dashboard");
        }
    }

    public function googleAction() {
        require('../vendor/google_oauth/Google_Client.php');
        require('../vendor/google_oauth/contrib/Google_PlusService.php');
        require('../vendor/google_oauth/contrib/Google_Oauth2Service.php');
        $config = include '../app/config/config.php';

        $client = new Google_Client();
        $client->setApplicationName($config->google->applicationName);
        $client->setRedirectUri('http://'.$_SERVER['HTTP_HOST'] .
        dirname(strtok($_SERVER['REQUEST_URI'],'?')) . "/google");

        $client->setClientId($config->google->clientId);
        $client->setClientSecret($config->google->clientSecret);
        $client->setDeveloperKey($config->google->developerKey);

        $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/plus.me'));
        $client->setApprovalPrompt('auto');

        $plus = new Google_PlusService($client);
        $oauth2 = new Google_Oauth2Service($client);

        if(isset($_GET['code'])){
            $client->authenticate();
            $_SESSION['access_token'] = $client->getAccessToken();
        }

        if(isset($_SESSION['access_token'])){
            $client->setAccessToken($_SESSION['access_token']);
        }

        if($client->getAccessToken()){
            $user = $oauth2->userinfo->get();
            $me = $plus->people->get('me');
            $profile_photo = "https://plus.google.com/s2/photos/profile/" . $me['id'] . "?sz=150";
            $optParams = array('maxResults' => 100);
            $activities = $plus->activities->listActivities('me','public',$optParams);
            $_SESSION['access_token'] = $client->getAccessToken();
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $success = true;
        } else{
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            $success = false;
        }

        if($success) {
            $schoolUser = User::findFirstByEmail($user['email']);

            if(!$schoolUser) {
                $schoolUser = new User();
                $schoolUser->schoolId = 1;
                $schoolUser->type = User::getTypeStudent();
                $schoolUser->name = $user['given_name'];
                $schoolUser->lastName = $user['family_name'];
                $schoolUser->password = "084e0343a0486ff05530df6c705c8bb4";
                $schoolUser->email = $user['email'];

                $schoolUser->save();
            }

            $userId=$schoolUser->id;
            $photo = UserPhoto::findFirst("userId = " . $userId);

            if (!$photo) {
                $photo = new UserPhoto();
                $photo->userId = $userId;
                $photo->originalName = $user['email'];
                $photo->name = $user['email'].rand();
                $photo->size = '';
                $photo->type = '';
                $photo->file = file_get_contents($profile_photo);

                $photo->save();
            }


            Authenticate::authenticationGoogle($schoolUser);
            return $this->response->redirect("dashboard");
        }
    }
}
