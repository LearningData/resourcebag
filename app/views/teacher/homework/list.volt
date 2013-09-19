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
            <td>{{ homework.studentId }}</td>
            <td>{{ homework.text }}</td>
            <td>{{ homework.setDate }}</td>
            <td>{{ homework.dueDate }}</td>
            <td>{{ homework.status }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>