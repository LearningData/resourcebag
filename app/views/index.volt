<!DOCTYPE html>
<html>
    <head>
        <title>Schoolbag</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/schoolbag/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/schoolbag/css/style.css" rel="stylesheet" media="screen">
        <link rel="stylesheet"
            href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    </head>
    {% if user is defined %}
        <header>
        {% set header = user.getController()~"/_header" %}
        {{ partial(header)}}
        </header>
    {% endif %}
    <body>
        <div>{{ content() }}</div>
        <script src="/schoolbag/js/jquery-1.9.1.js"></script>
        <script src="/schoolbag/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="/schoolbag/js/bootstrap.min.js"></script>
        <script src="/schoolbag/js/application.js"></script>
    </body>
</html>