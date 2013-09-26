<!DOCTYPE html>
<html>
	<head>
		<title>Schoolbag</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		{{ stylesheet_link("css/bootstrap.min.css") }}
		{{ stylesheet_link("css/style.css") }}
		<link rel="stylesheet"
		href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
					{{ content() }}
				</div>
			</div>
		</div>
		{{ javascript_include("js/jquery-1.9.1.js") }}
		{{ javascript_include("js/jquery-ui-1.10.3.custom.min.js") }}
		{{ javascript_include("js/bootstrap.min.js") }}
		{{ javascript_include("js/application.js") }}
	</body>
</html>