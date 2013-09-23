<h2>Homeworks</h2>
<h5>
    <a href="/schoolbag/teacher/homework/{{ classList.id }}">all</a> |
    <a href="/schoolbag/teacher/homework/{{ classList.id }}?filter=3">reviewed</a> |
    <a href="/schoolbag/teacher/homework/{{ classList.id }}?filter=2">submitted</a> |
</h5>
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
                {% if homework.isSubmitted() %}
                    {{ link_to("homework/review/"~homework.id, "Submitted") }}
                {% else %}
                    {{ homework.getStatus() }}
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>