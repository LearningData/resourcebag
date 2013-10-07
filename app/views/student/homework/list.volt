<div class="{{ (status == 0 ? "to-do" : (status == 2 ? "complete" : ( status == 3 ? "progress" : ""))) }}">
    <h1>Homework</h1>
    <nav class="nav-homework">
        <ul>
            <li class="bt-new">
                {{ link_to("student/homework/new", "Add New")}}
            </li>
            <!--li>{{ link_to("student/homework", "All") }}</li-->
            <li class="bt-to-do">
                {{ link_to("student/homework?filter=0", "To Do") }}
            </li>
            <li class="bt-progress">
                {{ link_to("student/homework?filter=3", "In Progress") }}
            </li>
            <li class="bt-complete">
                {{ link_to("student/homework?filter=2", "Complete") }}
            </li>
        </ul>

    </nav>
    <table id="accordion" class="accordion table table-homework">
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
            <tbody class="accordion-group">
                <tr>
                    <td data-toggle="collapse" data-parent="#accordion" data-target="#hw{{ homework.id }}">{{ homework.title }}</td>
                    <td>{{ homework.classList.subject.name }}</td>
                    <td>
                        {{ homework.classList.user.name }}
                        {{ homework.classList.user.lastName}}
                    </td>
                    <td>{{ homework.getDueDate() }}</td>
                    <td data-target="--">
                        {% if homework.isPending() %}
                            <span class="btn-icon btn-pending"> pending </span>
                        {% else %}
                        {% endif %}

                        {{ link_to("student/homework/edit/"~homework.id, "class":"btn-edit btn-icon", "Edit") }}
                        {{ link_to("student/homework/show/"~homework.id, "class":"btn-review btn-icon", "Show") }}
                        {{ link_to("student/homework/submit/"~homework.id, "class":"btn-submit btn-icon", "Submit") }}
                    </td>
                </tr>
                <tr  id="hw{{ homework.id }}" class="collapse">
                    <td colspan="5">{{ homework.text }}</td>
                </tr>
            </tbody>
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
</div>