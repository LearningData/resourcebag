{% include "teacher/_header.volt" %}
<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("teacher/update", "method":"post") }}
{% include "users/_update_form.volt" %}
