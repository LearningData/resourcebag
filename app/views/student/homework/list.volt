{{ content() }}
<h2>Homework</h2>
<h5>
    {{ link_to("student/homework/new", "New Homework")}} |
    {{ link_to("student/homework", "All") }} |
    {{ link_to("student/homework?filter=3", "Reviewed") }} |
    {{ link_to("student/homework?filter=2", "Submitted") }} |
    {{ link_to("student/homework?filter=0", "Pending") }}
</h5>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Homework</th>
            <th>Subject</th>
            <th>Teacher</th>
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
            <td>{{ homework.classList.subject.name }}</td>
            <td>
                {{ homework.classList.user.name }}
                {{ homework.classList.user.lastName}}
            </td>
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
            <td>
                {% if homework.isReviewed() %}
                    {{ link_to("homework/show/"~homework.id, "Reviewed")}}
                {% else %}
                    {{ homework.getStatus()}}
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>