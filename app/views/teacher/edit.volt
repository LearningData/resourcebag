<table width="100%">
    <tr>
        <td align="left">{{ link_to("teacher", "Go Back") }}</td>
    <tr>
</table>

<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("teacher/update", "method":"post") }}
{% include "users/_update_form.volt" %}