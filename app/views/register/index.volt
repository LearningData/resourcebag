<h1>Your Info</h1>

{{ content() }}

{{ form("register/create", "method":"post") }}
{% include "users/_form.volt" %}