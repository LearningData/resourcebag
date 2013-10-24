    <h1 class="homework-header">Homework</h1>
    <nav class="status-{{ status }} nav-homework">
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
        <thead>
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
            <tr class="{{ (homework.status == 0 ? "to-do" : (homework.status >= 2 ? "complete" : ( homework.status == 1 ? "in-progress" : "reviewed"))) }}">
                <td class="homework-collapse" data-target="#hw{{ homework.id }}" data-icon="#hwicon{{ homework.id }}"><span id="hwicon{{ homework.id }}" class="collapse-icon icon-chevron-right"></span>{{ homework.title }}</td>
                <td class="homework-collapse" data-target="#hw{{ homework.id }}" data-icon="#hwicon{{ homework.id }}"">{{ homework.classList.subject.name }}</td>
                <td class="homework-collapse" data-target="#hw{{ homework.id }}" data-icon="#hwicon{{ homework.id }}">
                    {{ homework.classList.user.name }}
                    {{ homework.classList.user.lastName}}
                </td>
                <td class="homework-collapse" data-target="#hw{{ homework.id }}" data-icon="#hwicon{{ homework.id }}">{{ homework.getDueDate() }}</td>
                <td data-target="--">
                    {% if homework.isPending() %}
                        {{ link_to("student/homework/start/"~homework.id,
                            "class":"btn-icon btn-pending icon-caret-right", "title":"Start")}}
                    {% endif %}

                    {{ link_to("student/homework/edit/"~homework.id, "class":"btn-icon btn-edit icon-pencil", "title":"Edit") }}
                    {{ link_to("student/homework/show/"~homework.id, "class":"btn-review btn-icon icon-eye-open", "title":"Show") }}
                    {% if !homework.Files.count() %}
                    <span data-title="{{ homework.title }}" class="btn-submit btn-inactive btn-icon icon-ok" title="Please upload a file"></span>
                    {% else %}
                    <span data-count="{{ homework.Files.count() }}" data-title="{{ homework.title }}" data-homework-id="{{ homework.id }}" class="btn-submit btn-icon icon-ok" title="Submit"></span>
                    {% endif %}
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
    </ul>
