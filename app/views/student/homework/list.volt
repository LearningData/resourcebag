<h2>Active {{ classList.subject.name }} ({{ classList.extraRef }})</h2>
<h5>
    <a href="/schoolbag/student/homework/{{ classList.id }}">all</a> |
    <a href="/schoolbag/student/homework/{{ classList.id }}?filter=r">reviewed</a> |
    <a href="/schoolbag/student/homework/{{ classList.id }}?filter=s">submitted</a> |
    <a href="/schoolbag/student/homework/{{ classList.id }}?filter=p">pending</a>
</h5>
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
            {% if homework.isPending() %}
                <td>
                    {{ link_to("student/homework/answer/"~homework.id, "Edit") }}
                </td>
                <td>
                    {{ link_to("student/homework/submit/"~homework.id, "Submit") }}
                </td>
            {% else %}
                <td></td>
                <td></td>
            {% endif %}
            <td>{{ homework.setDate }}</td>
            <td>{{ homework.dueDate }}</td>
            <td>{{ homework.getStatus()}}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>