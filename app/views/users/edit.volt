<table width="100%">
    <tr>
        <td align="left">{{ link_to("users", "Go Back") }}</td>
    <tr>
</table>

<div align="center">
    <h1>Edit users</h1>
</div>

{{ form("users/update", "method":"post") }}
{% include "users/_form.volt" %}
