<h1>Homework</h1>
<nav class="nav-homework">
    <ul>
        <li class="bt-new">
            {{ link_to("student/homework/new", "Add New")}}
        </li>
        <!--li>{{ link_to("student/homework", "All") }}</li-->
        <li>
            {{ link_to("student/homework?filter=0", "To Do") }}
        </li>
        <li>
            {{ link_to("student/homework?filter=3", "In Progress") }}
        </li>
        <li>
            {{ link_to("student/homework?filter=2", "Complete") }}
        </li>
    </ul>

</nav>
<table class="table table-homework">
        <tr>
            <th>Homework</th>
            <th>Subject</th>
            <th>Teacher</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        {% for homework in page.items %}
        <tr>
            <td>{{ homework.text }}</td>
            <td>{{ homework.classList.subject.name }}</td>
            <td> {{ homework.classList.user.name }}{{ homework.classList.user.lastName}} </td>
            <td>{{ homework.dueDate }}</td>
            <td>
                {% if homework.isPending() %}
                    <span class="btn-icon btn-pending"> pending </span>
                {% else %}
                {% endif %}

                {{ link_to("student/homework/answer/"~homework.id, "class":"btn-edit btn-icon", "Edit") }}
                {{ link_to("student/homework/submit/"~homework.id, "class":"btn-submit btn-icon", "Submit") }}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="display: none;">description</td>
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