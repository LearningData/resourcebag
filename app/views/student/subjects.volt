<h2>Subjects</h2>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Class</th>
            <th></th>
            <th></th>
            <th>Teacher</th>
        </tr>
    </thead>
    <tbody>
    {% for classList in user.classList %}
        <tr>
            <td>
                <a href="#">
                    {{classList.subject.name }} ({{ classList.extraRef }})
                </a>
            </td>
            <td>{{ link_to("student/homework/new/"~classList.id, "New") }}</td>
            <td>{{ link_to("student/homework/"~classList.id, "Show") }}</td>
            <td>{{ classList.user.name }} {{ classList.user.lastName }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>