    <h1 class="homework-header">Homework</h1>
    <nav class="nav-homework">
        <ul>
            <li class="bt-new">
                {{ link_to("student/homework/new", "Add New")}}
            </li>
            <!--li>{{ link_to("student/homework", "All") }}</li-->
            <li class="bt-to-do">
                {{ link_to("student/homework?filter=0", "To Do") }}
            </li>
            <li class="bt-in-progress">
                {{ link_to("student/homework?filter=1", "In Progress") }}
            </li>
            <li class="bt-complete">
                {{ link_to("student/homework?filter=2", "Complete") }}
            </li>
        </ul>
    </nav>
    <table class="accordion table table-homework">
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
            <tr class="{{ (homework.status == 0 ? "to-do" : (home-work.status >= 2 ? "complete" : ( homework.status == 1 ? "in-progress" : "reviewed"))) }}">
                <td data-toggle="collapse" data-target="#hw{{ homework.id }}">{{ homework.title }}</td>
                <td>{{ homework.classList.subject.name }}</td>
                <td>
                    {{ homework.classList.user.name }}
                    {{ homework.classList.user.lastName}}
                </td>
                <td>{{ homework.getDueDate() }}</td>
                <td data-target="--">
                    {% if homework.isPending() %}
                        {{ link_to("student/homework/start/"~homework.id,
                            "class":"btn-icon btn-pending", "Start")}}
                    {% endif %}

                    {{ link_to("student/homework/edit/"~homework.id, "class":"btn-edit btn-icon", "Edit") }}
                    {{ link_to("student/homework/show/"~homework.id, "class":"btn-review btn-icon", "Show") }}
                    <span data-title="{{ homework.title }}" data-homework-id="{{ homework.id }}" class="btn-submit btn-icon">"Submit"</span>
                </td>
            </tr>
            <tr  id="hw{{ homework.id }}" class="collapse">
                <td colspan="5">{{ homework.text }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
    <ul class="paginator homework">
        <li>{{ link_to("/homework?page="~page.before~"&filter="~status, "class":"icon-chevron-left Prev" ) }}</li>
        {% for link in links %}
            <li>{{ link_to(link['url'], link['page']) }}</li>
        {% endfor %}
        <li>{{ link_to("/homework?page="~page.next~"&filter="~status, "class":"icon-chevron-right Next") }}</li>
    </li>
