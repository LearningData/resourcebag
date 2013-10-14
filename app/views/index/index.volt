<!DOCTYPE html>
<html>
    <head>
        <title>Schoolbag</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/style.css") }}
    </head>
    <body id="login">
        <div class="row">
            <div class="col-lg-12 ">
                <header class="header-login">
                    <div class="container">
                        <a href="/" class=""> <img width="153" heigth="46" src="img/logo-login.png" alt="Schoolbag"></a>
                    </div>
                </header>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 ">
                    <div class="col-block-images">
                        <div class="block1">
                            <img src="img/artwork/art-work-01.jpg" width="160" height="180" />
                            <img src="img/artwork/art-work-02.jpg" width="80" height="90" />
                            <img src="img/artwork/art-work-03.jpg" width="80" height="90" />
                            <img src="img/artwork/art-work-04.jpg" width="160" height="90" />
                        </div>
                        <div class="block2">
                            <img src="img/artwork/art-work-06.jpg" width="60" height="65" />
                            <img src="img/artwork/art-work-07.jpg" width="60" height="65" />
                            <img src="img/artwork/art-work-05.jpg" width="120" height="135" />
                            <img src="img/artwork/art-work-08.jpg" width="160" height="90" />
                        </div>
                        <div class="block3">
                            <img src="img/artwork/art-work-09.jpg" width="80" height="90" />
                            <img src="img/artwork/art-work-12.jpg" width="80" height="45" />
                            <img src="img/artwork/art-work-10.jpg" width="40" height="45" />
                            <img src="img/artwork/art-work-11.jpg" width="40" height="45" />

                        </div>
                        <div class="block4">
                            <img src="img/artwork/art-work-14.jpg" width="20" height="23" />
                            <img src="img/artwork/art-work-15.jpg" width="20" height="23" />
                            <img src="img/artwork/art-work-13.jpg" width="40" height="45" />
                            <img src="img/artwork/art-work-16.jpg" width="40" height="23" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="col-login">
                        {{ form("session/login", "method":"post") }}
                        <p>
                            {{ text_field("email", "placeholder":"Email", "class":"form-control") }}
                        </p>
                        {{ password_field("password","placeholder":"Password", "class":"form-control" ) }}

                        {{ submit_button("Login","class":"btn btn-login") }}
                        {{ link_to("register", "Sign Up","class":"btn btn-login") }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{ javascript_include("js/jquery-1.9.1.js") }}
        {{ javascript_include("js/bootstrap.min.js") }}
        {{ javascript_include("js/createTimetable.js") }}
        {{ javascript_include("js/application.js") }}
    </body>
</html>

