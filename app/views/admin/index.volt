{% include "admin/_header.volt" %}

{{ content() }}

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
                <td>{{ school.schoolID }}</td>
                <td>{{ school.SchoolName }}</td>
                <td>{{ school.Address }}</td>
                <td>{{ school.SchoolPath }}</td>
                <td>{{ school.AccessCode }}</td>
                <td>{{ school.TeacherAccessCode }}</td>
                <td>{{ school.allTY }}</td>

                <td>{{ link_to("admin/editSchool/"~school.schoolID, "Edit") }}</td>
                <td>{{ link_to("admin/deleteSchool/"~school.schoolID, "Delete") }}</td>
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
