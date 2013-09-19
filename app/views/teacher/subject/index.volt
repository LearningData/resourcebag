<h1>Subjects</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Class</th>
            <th></th>
            <th></th>
            <th>Year</th>
            <th>Students</th>
        </tr>
    </thead>
    <tbody>
    {% for classList in classes %}
        <tr>
            <td>
                <a href="#">
                    {{classList.subject.name }} ({{ classList.extraRef }})
                </a>
            </td>
            <td>{{ link_to("teacher/homework/new/"~classList.id, "New") }}</td>
            <td><a href="#">Correct</a></td>
            <td>{{ classList.year }}</td>
            {% if classList.users.count() %}
                <td>
                    <a data-toggle="modal" href="#modal{{ classList.id }}">
                        {{ classList.users.count() }}
                    </a>
                    {% include "teacher/modal_users.volt" %}
                </td>
            {% else %}
                <td>{{ classList.users.count() }}</td>
            {% endif %}
        </tr>
    {% endfor %}
    </tbody>
</table>