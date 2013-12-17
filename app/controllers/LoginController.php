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

        $newUser = array();
        $newUser['authprovider'] = "microsoft";
        $newUser['photo'] = "";
        $newUser['name'] = $user->first_name;
        $newUser['lastname'] = $user->last_name;
        $newUser['email'] = $user->emails->preferred;

        session_start(); 
        $_SESSION['newUser'] = $newUser;

        if($success) {
            $schoolUser = User::findFirstByEmail($user->emails->preferred);

            if(!$schoolUser) {
                return $this->response->redirect("register/accessCode");
            } else {
                Authenticate::authenticationMicrosoft($schoolUser);
                return $this->response->redirect("dashboard");
            }
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

        if(isset($_GET['code'])) {
            $client->authenticate();
            $_SESSION['access_token'] = $client->getAccessToken();
        }

        if(isset($_SESSION['access_token'])) {
            $client->setAccessToken($_SESSION['access_token']);
        }

        if($client->getAccessToken()) {
            $user = $oauth2->userinfo->get();
            $user = array_merge($user,$plus->people->get('me'));

            $newUser = array();
            $newUser['authprovider'] = "google";
            $newUser['photo'] = "https://plus.google.com/s2/photos/profile/" . $user['id'] . "?sz=150";
            $newUser['name'] = $user['given_name'];
            $newUser['lastname'] = $user['family_name'];
            $newUser['email'] = $user['email'];

            session_start(); 
            $_SESSION['newUser'] = $newUser;

            $_SESSION['access_token'] = $client->getAccessToken();
            $success = true;
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            $success = false;
        }

        if($success) {
            $schoolUser = User::findFirstByEmail($user['email']);

            if(!$schoolUser) {
                return $this->response->redirect("register/accessCode");
            } else {
                Authenticate::authenticationGoogle($schoolUser);
                return $this->response->redirect("dashboard");
            }
        }
    }
}
