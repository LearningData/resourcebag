{% include "admin/_header.volt" %}

{{ content() }}

<div align="center">
    <h1>New School</h1>
</div>

<center>
{{ form("admin/createSchool", "method":"post") }}
{% include "admin/schools/_form.volt" %}
</center>