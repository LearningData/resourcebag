<h1>Listing classes</h1>
<table>
{% for listClass in classes %}
    <tr>
        <td>{{ listClass.extraRef }} </td>
        <td>{{ link_to("teacher/deleteClass/"~listClass.id, "Remove Class") }}</td>
{% endfor %}
</table>