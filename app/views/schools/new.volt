<table width="100%">
    <tr>
        <td align="left">{{ link_to("schools", "Go Back") }}</td>
    <tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create schoolinfo</h1>
</div>

{{ form("schools/create", "method":"post") }}
{% include "schools/_form.volt" %}