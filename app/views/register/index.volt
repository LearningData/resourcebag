<!DOCTYPE html>
<html>
    <head>
        <title>{{ t._("global.title") }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/style.css") }}
    </head>
    <body id="signup">
        <div class="jumbotron">
            <div class="container">
                <header>
                    <a href="/" class="schoolbag-brand-login"> <img width="153" heigth="46" src="img/logo-login.png" alt="Schoolbag"></a>
                </header>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="">
                    <h1>Your Info</h1>
                    <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                    {{ form("register/create", "method":"post") }}
                    {% include "users/_form.volt" %}

                </div>
            </div>
            {{ javascript_include("js/jquery-1.9.1.js") }}
            {{ javascript_include("js/bootstrap.min.js") }}
            {{ javascript_include("js/application.js") }}
    </body>
</html>

