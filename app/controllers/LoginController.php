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
}