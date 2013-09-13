{% include "school/_header.volt" %}

<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("school/update", "method":"post") }}
{% include "users/_update_form.volt" %}
