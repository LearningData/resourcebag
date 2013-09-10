{% include "admin/_header.volt" %}

{{ content() }}

<div align="center">
    <h1>Edit School</h1>
</div>

{{ form("admin/updateSchool", "method":"post") }}
{% include "admin/schools/_form.volt" %}
