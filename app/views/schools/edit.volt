<table width="100%">
    <tr>
        <td align="left">{{ link_to("schools", "Go Back") }}</td>
    <tr>
</table>

<div align="center">
    <h1>Edit schoolinfo</h1>
</div>

{{ form("schools/update", "method":"post") }}
{% include "schools/_form.volt" %}
