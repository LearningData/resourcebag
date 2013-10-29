<div class="homework orange">
    <h2>Homeworks</h2>
    <nav class="status{{ status }} nav-homework">
        <ul>
            <li class="bt-new">
                {{ link_to("student/homework/new", "Add New")}}
            </li>
            <li class="btn-all">
                {{ link_to("student/homework", "All") }}
            </li>
            <li class="bt-complete">
                {{ link_to("student/homework?filter=2", "Submitted") }}
            </li>
            <li class="btn-reviewed">
                {{ link_to("student/homework?filter=3", "Reviewed") }}
            </li>
        </ul>
    </nav>

    {{ form("homework/reviewManyHomeworks", "method":"post", "class":"form") }}
        <table class="table">
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
                    <td>{{ homework.title }}</td>
                    <td>{{ homework.setDate }}</td>
                    <td>{{ homework.dueDate }}</td>
                    {% if homework.isSubmitted() %}
                        <td>
                            {{ link_to("teacher/homework/review/"~homework.id, "Submitted") }}
                        </td>
                        <td>
                            <input type="checkbox"
                                name="ids[]" value="{{ homework.id }}">
                        </td>
                    {% else %}
                        <td>
                        {% if homework.isReviewed() %}
                            {{ link_to("teacher/homework/show/"~homework.id, "Reviewed") }}
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
        <ul class="paginator homework">
            <li>{{ link_to("teacher/homework?page="~page.before~"&filter="~status, "class":"icon-chevron-left Prev") }}</li>
            {% for link in links %}
                <li>{{ link_to(link['url'], link['page']) }}</li>
            {% endfor %}
            <li>{{ link_to("teacherhomework?page="~page.next~"&filter="~status, "class":"icon-chevron-right Next") }}</li>
        </li>
        </ul>
        <input type="submit" class="btn btn-left">
    </form>
</div>
