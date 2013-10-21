<h1>Subjects</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Class</th>
            <th></th>
            <th></th>
            <th>In Progress</th>
            <th>Submitted</th>
            <th>Year</th>
            <th>Students</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for classList in classes %}
        <tr>
            <td>
                {{ link_to("teacher/showClass/"~classList.id,
                    classList.subject.name~"("~classList.extraRef~")") }}

            </td>
            <td>{{ link_to("teacher/homework/new/"~classList.id, "New") }}</td>
            <td>{{ link_to("teacher/homework/class/"~classList.id~"?filter=2",
                "Correct") }}</td>
            <td>{{ classList.getPendingHomework().count() }}</td>
            <td>{{ classList.getSubmittedHomework().count() }}</td>
            <td>{{ classList.cohort.stage }}</td>
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
            <td>
                {{ link_to("teacher/deleteClass/"~classList.id,
                    "Remove this class") }}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>

{{ link_to("teacher/newClass", "Create a New Class") }}