<h1>Your Info</h1>

{{ content() }}

{{ form("users/create", "method":"post") }}
{% include "users/_form.volt" %}