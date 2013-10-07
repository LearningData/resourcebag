<h2>Homeworks</h2>
{{ form("homework/reviewManyHomeworks", "method":"post") }}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Student</th>
                <th>Homework</th>
                <th>Assigned Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
        {% for homework in page.items %}
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
                    <td>
                    {% if homework.isReviewed() %}
                        {{ link_to("homework/show/"~homework.id, "Reviewed") }}
                    {% else %}
                        {{ homework.getStatus() }}
                    {% endif %}
                    </td>
                    <td></td>
                {% endif %}
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <ul>
        <li>{{ link_to("/homework?page="~page.before~"&filter="~status, "Prev") }}</li>
        {% for link in links %}
            <li>{{ link_to(link['url'], link['page']) }}</li>
        {% endfor %}
        <li>{{ link_to("/homework?page="~page.next~"&filter="~status, "Next") }}</li>
    </li>
    <input type="submit">
</form>