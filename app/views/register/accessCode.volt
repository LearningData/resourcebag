<!DOCTYPE html>
<html>
    <head>
        <title>{{ t._("global.title") }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/style.css") }}
        {{ stylesheet_link("css/media.css") }}        
        {{ stylesheet_link("css/uniform.default.css") }}
        {{ stylesheet_link("css/orange.css") }}

    </head>
    <body id="signup">
        <div class="jumbotron">
            <div class="container">
                <header>
                    <a href="/schoolbag" class="schoolbag-brand-login"> <img width="153" heigth="46" src="img/logo-login.png" alt="Schoolbag"></a>
                </header>
            </div>
        </div>
        <div class="container">
                <h1>Access Code</h1>
                <h2 class="page-header">Insert the code provided by your school</h2>
                <div class="col-sm-6 orange">
                    {{ form("register/accessCodeCheck", "method":"post") }}

                        <label for="accessCode">{{ t._("Access Code") }}</label>
                        {{ text_field("accessCode", "placeholder":t._("Access Code")) }}

                        {{ submit_button("Submit code", "class":"btn") }}
                    </form>
                </div>
        </div>
            {{ javascript_include("js/jquery-1.9.1.js") }}
            {{ javascript_include("js/bootstrap.min.js") }}
            {{ javascript_include("js/jquery.uniform.min.js") }}
            {{ javascript_include("js/application.js") }}
    </body>
</html>

