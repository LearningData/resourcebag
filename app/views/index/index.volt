<!DOCTYPE html>
<html>
    <head>
        <title>{{ t._("title") }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/style.css") }}
        {{ stylesheet_link("css/media.css") }}
    </head>
    <body id="login">
        <div class="jumbotron">
            <div class="container">
                <header>
                    <a href="/" class="schoolbag-brand-login"> <img width="153" heigth="46" src="img/logo-login.png" alt="Schoolbag"></a>
                </header>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="hidden-xs col-sm-5 col-md-6 col-lg-7 ">
                    <div class="col-block-images">
                        <div class="block1">
                            <img src="img/artwork/art-work-01.jpg" width="160" height="180" class="img-responsive" />
                            <img src="img/artwork/art-work-02.jpg" width="80" height="90" class="img-responsive" />
                            <img src="img/artwork/art-work-03.jpg" width="80" height="90" class="img-responsive" />
                            <img src="img/artwork/art-work-04.jpg" width="160" height="90" class="img-responsive" />
                        </div>
                        <div class="block2">
                            <img src="img/artwork/art-work-06.jpg" width="60" height="65" class="img-responsive" />
                            <img src="img/artwork/art-work-07.jpg" width="60" height="65" class="img-responsive" />
                            <img src="img/artwork/art-work-05.jpg" width="120" height="135" class="img-responsive" />
                            <img src="img/artwork/art-work-08.jpg" width="160" height="90" class="img-responsive" />
                        </div>
                        <div class="block3">
                            <img src="img/artwork/art-work-09.jpg" width="80" height="90" class="img-responsive" />
                            <img src="img/artwork/art-work-12.jpg" width="80" height="45" class="img-responsive" />
                            <img src="img/artwork/art-work-10.jpg" width="40" height="45" class="img-responsive" />
                            <img src="img/artwork/art-work-11.jpg" width="40" height="45" class="img-responsive" />
                        </div>
                        <div class="block4">
                            <img src="img/artwork/art-work-14.jpg" width="20" height="23" class="img-responsive" />
                            <img src="img/artwork/art-work-15.jpg" width="20" height="23" class="img-responsive" />
                            <img src="img/artwork/art-work-13.jpg" width="40" height="45" class="img-responsive" />
                            <img src="img/artwork/art-work-16.jpg" width="40" height="23" class="img-responsive" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-md-6 col-lg-5">
                    {% for type, messages in flash.getMessages() %}
                    {% for message in messages %}
                    <div class="alert">
                        {{ message }}
                    </div>
                    {% endfor %}
                    {% endfor %}
                    {{ content() }}
                    <div class="col-login">
                        {{ form("session/login", "method":"post") }}
                        <p>
                            <input name="email" type="email", placeholder="Email", class="form-control" autofocus/>
                        </p>
                        {{ password_field("password","placeholder":"Password", "class":"form-control" ) }}

                        {{ securityTag.csrf(csrf_params) }}

                        {{ submit_button(t._("login"),"class":"btn btn-login") }}
                        {{ link_to("register", t._("sign-up"),"class":"btn btn-login") }}
                        </form>
                        <br>
                        <p>
                            {{ link_to("login/microsoft",
                                "Login with Microsoft", "#")}}
                        </p>
                    </div>
                </div>
            </div>
            {{ javascript_include("js/jquery-1.9.1.js") }}
            {{ javascript_include("js/bootstrap.min.js") }}
    </body>
</html>

