<nav>
    {{ link_to("admin/newSchool", "New School") }}
    {{ link_to("admin", "View Schools") }}
    {{ link_to("admin/listConfigs", "View Configurations") }}
    {{ link_to("admin/newConfig", "New Configuration") }}
</nav>
<center><h1>Listing school</h1></center>
<table class="browse" align="center">
    <thead>
        <tr>
            <th>SchoolID</th>
            <th>SchoolName</th>
            <th>Address</th>
            <th>SchoolPath</th>
            <th>AccessCode</th>
            <th>TeacherAccessCode</th>
            <th>AllTY</th>
        </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
        {% for school in page.items %}
            <tr>
                <td>{{ school.id }}</td>
                <td>{{ school.name }}</td>
                <td>{{ school.address }}</td>
                <td>{{ school.path }}</td>
                <td>{{ school.accessCode }}</td>
                <td>{{ school.teacherAccessCode }}</td>
                <td>{{ school.allTY }}</td>

                <td>{{ link_to("admin/editSchool/"~school.id, "Edit") }}</td>
                <td>{{ link_to("admin/deleteSchool/"~school.id, "Delete") }}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("admin/", "First") }}</td>
                        <td>{{ link_to("admin/?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("admin/?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("admin/?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    <tbody>
</table>
