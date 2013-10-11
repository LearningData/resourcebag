<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("school/update", "method":"post", "enctype":"multipart/form-data") }}
{% include "users/_update_form.volt" %}
