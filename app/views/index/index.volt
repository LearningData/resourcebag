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
                    <a href="/" class="schoolbag-brand-login">{{ image("img/logo.png", "alt":"Schoolbag","width":"153", "heigth":"46") }}</a>
                </header>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="hidden-xs col-sm-5 col-md-6 col-lg-7 ">
                    <div class="col-block-images">
                        <div class="block1">
                            {{ image("img/artwork/art-work-01.jpg", "alt":"Schoolbag","width":"160", "heigth":"180", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-02.jpg", "alt":"Schoolbag","width":"80", "heigth":"180", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-03.jpg", "alt":"Schoolbag","width":"80", "heigth":"180", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-04.jpg", "alt":"Schoolbag","width":"160", "heigth":"180", "class":"img-responsive") }}
                        </div>
                        <div class="block2">
                            {{ image("img/artwork/art-work-06.jpg", "alt":"Schoolbag","width":"60", "heigth":"65", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-07.jpg", "alt":"Schoolbag","width":"60", "heigth":"65", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-05.jpg", "alt":"Schoolbag","width":"120", "heigth":"135", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-08.jpg", "alt":"Schoolbag","width":"160", "heigth":"90", "class":"img-responsive") }}
                        </div>
                        <div class="block3">
                            {{ image("img/artwork/art-work-09.jpg", "alt":"Schoolbag","width":"80", "heigth":"90", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-12.jpg", "alt":"Schoolbag","width":"80", "heigth":"45", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-10.jpg", "alt":"Schoolbag","width":"40", "heigth":"45", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-11.jpg", "alt":"Schoolbag","width":"40", "heigth":"45", "class":"img-responsive") }}
                        </div>
                        <div class="block4">
                            {{ image("img/artwork/art-work-14.jpg", "alt":"Schoolbag","width":"20", "heigth":"23", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-15.jpg", "alt":"Schoolbag","width":"20", "heigth":"23", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-13.jpg", "alt":"Schoolbag","width":"40", "heigth":"23", "class":"img-responsive") }}
                            {{ image("img/artwork/art-work-16.jpg", "alt":"Schoolbag","width":"40", "heigth":"23", "class":"img-responsive") }}
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
                            <input name="email" type="text", placeholder="Email", class="form-control" autofocus/>
                        </p>
                        {{ password_field("password","placeholder":"Password", "class":"form-control" ) }}

                        {{ securityTag.csrf(csrf_params) }}

                        {{ submit_button(t._("login"),"class":"btn btn-login") }}
                        {{ link_to("register", t._("sign-up"),"class":"btn btn-login") }}
                        </form>
                        <br>
                        <p>
                            <a href="login/microsoft"> {{ image("img/microsoft_login.png", "alt":"Login with Microsoft") }} </a>
                            <a href="login/google"> {{ image("img/google_login.png", "alt":"Login with Google", "width":"208px", "height":"30px") }} </a>
                        </p>
                    </div>
                </div>
            </div>
            {{ javascript_include("js/jquery-1.9.1.js") }}
            {{ javascript_include("js/bootstrap.min.js") }}
    </body>
</html>

