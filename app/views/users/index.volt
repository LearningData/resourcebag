<div align="right">
    {{ link_to("users/new", "Create users") }}
</div>

<h1>Listing users</h1>
<table class="browse" align="center">
    <thead>
        <tr>
            <th>UserID</th>
            <th>SchoolID</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Type</th>
            <th>Email</th>
            <th>Password</th>

        </tr>
    </thead>
    <tbody>
        {% if page.items is defined %}
        {% for user in page.items %}
        <tr>
            <td>{{ user.userID }}</td>
            <td>{{ user.schoolID }}</td>
            <td>{{ user.FirstName }}</td>
            <td>{{ user.LastName }}</td>
            <td>{{ user.Type }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.password }}</td>

            <td>{{ link_to("users/edit/"~user.userID, "Edit") }}</td>
            <td>{{ link_to("users/delete/"~user.userID, "Delete") }}</td>
        </tr>
        {% endfor %}
        {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
            <table align="center">
                <tr>
                    <td>{{ link_to("users/", "First") }}</td>
                    <td>{{ link_to("users/?page="~page.before, "Previous") }}</td>
                    <td>{{ link_to("users/?page="~page.next, "Next") }}</td>
                    <td>{{ link_to("users/?page="~page.last, "Last") }}</td>
                    <td>{{ page.current~"/"~page.total_pages }}</td>
                </tr>
            </table></td>
        </tr>
    <tbody>
</table>
