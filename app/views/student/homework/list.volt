<h2>Active {{ classList.subject.name }} ({{ classList.extraRef }})</h2>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Homework</th>
            <th></th>
            <th></th>
            <th>Assigned Date</th>
            <th>Due Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    {% for homework in homeworks %}
        <tr>
            <td>{{ homework.text }}</td>
            <td>
                {{ link_to("student/homework/answer/"~homework.id, "Edit") }}
            </td>
            <td>
                {{ link_to("student/homework/submit/"~homework.id, "Submit") }}
            </td>
            <td>{{ homework.setDate }}</td>
            <td>{{ homework.dueDate }}</td>
            <td>{{ homework.status }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>