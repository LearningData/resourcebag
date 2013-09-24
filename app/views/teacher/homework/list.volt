<h2>Homeworks</h2>
<h5>
    <a href="/schoolbag/teacher/homework/{{ classList.id }}">all</a> |
    <a href="/schoolbag/teacher/homework/{{ classList.id }}?filter=3">reviewed</a> |
    <a href="/schoolbag/teacher/homework/{{ classList.id }}?filter=2">submitted</a>
</h5>
<form action="/schoolbag/homework/reviewManyHomeworks" method="post">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Student</th>
                <th>Homework</th>
                <th>Assigned Date</th>
                <th>Due Date</th>
                <th>Submitted</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
        {% for homework in homeworks %}
            <tr>
                <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
                <td>{{ homework.text }}</td>
                <td>{{ homework.setDate }}</td>
                <td>{{ homework.dueDate }}</td>
                {% if homework.isSubmitted() %}
                    <td>
                        {{ link_to("homework/review/"~homework.id, "Submitted") }}
                    </td>
                    <td>
                        <input type="checkbox"
                            name="ids[]" value="{{ homework.id }}">
                    </td>
                {% else %}
                    <td>{{ homework.getStatus() }}</td>
                    <td></td>
                {% endif %}
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <input type="hidden" name="class-id" value="{{ homework.classId }}">
    <input type="submit">
</form>