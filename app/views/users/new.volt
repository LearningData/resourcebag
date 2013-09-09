<table width="100%">
    <tr>
        <td align="left">{{ link_to("users", "Go Back") }}</td>
    <tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create users</h1>
</div>

{{ form("users/create", "method":"post") }}
{% include "users/_form.volt" %}