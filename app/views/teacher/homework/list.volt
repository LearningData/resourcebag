<h2>Homeworks</h2>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Student</th>
            <th>Homework</th>
            <th>Assigned Date</th>
            <th>Due Date</th>
            <th>Submitted</th>
        </tr>
    </thead>
    <tbody>
    {% for homework in homeworks %}
        <tr>
            <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
            <td>{{ homework.text }}</td>
            <td>{{ homework.setDate }}</td>
            <td>{{ homework.dueDate }}</td>
            <td>
                {% if homework.submittedDate == "0000-00-00" %}
                    Not submitted yet
                {% else %}
                    {{ link_to("homework/review/"~homework.id, "Submitted") }}
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>