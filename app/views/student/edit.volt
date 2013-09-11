<table width="100%">
    <tr>
        <td align="left">{{ link_to("student", "Go Back") }}</td>
    <tr>
</table>

<div align="center">
    <h1>Edit user</h1>
</div>

{{ form("student/update", "method":"post") }}
{% include "student/_form.volt" %}
