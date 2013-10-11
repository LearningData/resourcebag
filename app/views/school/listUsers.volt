<h1>Listing Users</h1>

<table>
    <thead>
        <th>User</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        {% for user in users %}
            <tr>
                <td>{{ user.name }} {{ user.lastName }}</td>
                <td>{{ link_to("school/editUser/"~user.id, "Edit") }}</td>
                <td>{{ link_to("users/remove/"~user.id, "Remove") }}</td>
            </tr>
        {% endfor %}
    </tbody>

</table>