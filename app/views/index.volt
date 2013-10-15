<!DOCTYPE html>
<html>
    <head>
        <title>Schoolbag</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ stylesheet_link("css/bootstrap.min.css") }}
        {{ stylesheet_link("css/font-awesome.min.css") }}
        {{ stylesheet_link("css/summernote.css") }}
        {{ stylesheet_link("css/summernote-bootstrap.css") }}
        {{ stylesheet_link("css/style.css") }}
        {{ stylesheet_link("css/uniform.default.css") }}
        {{ stylesheet_link("css/jquery.gridster.min.css") }}
        {{ stylesheet_link("css/fullcalendar.css") }}

        <!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="sidebar col-lg-3 ">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {% if user is defined %}
                    <header>
                        {% set header = user.getController()~"/_header" %}
                        {{ partial(header)}}
                        {{ partial(user.getController()~"/_sidebar") }}
                    </header>
                    {% endif %}
                </div>
                <div class="col-lg-9">
                    {% for type, messages in flash.getMessages() %}
                        {% for message in messages %}
                          <div class="alert">
                                {{ message }}
                           </div>
                        {% endfor%}
                    {% endfor %}
                    {{ content() }}
                </div>
            </div>
        </div>
        {{ javascript_include("js/jquery-1.9.1.js") }}
        {{ javascript_include("js/jquery-ui-1.10.3.custom.min.js") }}
        {{ javascript_include("js/bootstrap.min.js") }}
        {{ javascript_include("js/jquery.uniform.min.js") }}
        {{ javascript_include("js/jquery.gridster.min.js") }}
        {{ javascript_include("js/jquery.slimscroll.min.js") }}
        {{ javascript_include("js/summernote.min.js") }}
        {{ javascript_include("js/fullcalendar.min.js") }}
        {{ javascript_include("js/createTimetable.js") }}
        {{ javascript_include("js/dashboard.js") }}
        {{ javascript_include("js/timetable.js") }}
        {{ javascript_include("js/homework.js") }}
        {{ javascript_include("js/notices.js") }}
        {{ javascript_include("js/application.js") }}
    </body>
</html>
