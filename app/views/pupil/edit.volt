{% include "pupil/_header.volt" %}

<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("pupil/update", "method":"post") }}
{% include "users/_update_form.volt" %}
