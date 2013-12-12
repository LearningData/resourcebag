<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
    </header>
    <table class="table table-hover week-view fixed">
        <thead>
            <tr>
                <th>{{ t._("due-date") }}</th>
                <th>{{ t._("title-label") }}</th>
                <th>{{ t._("students") }}</th>
                <th>{{ t._("status") }}</th>
                <th>{{ t._("action") }}</th>
            </tr>
        </thead>
        <tbody>
        {% for item in page.items %}
            <tr class="week-group">
                <td class="format-date" data-date-special="week-begins">{{ item["start"] }}</td>
                <td></td><td></td><td></td><td></td>
            </tr>
            {% for homework in item["homeworks"] %}
                <tr class="{{ (homework.status == 0 ? 'not-started' : (homework.status == 2 ? 'to-review' : ( homework.status == 1 ? 'in-progress' : 'reviewed'))) 
                    }}{% if homework.submittedDate > homework.info.dueDate %} overdue {% 
                        elseif homework.submittedDate == 0 and homework.info.dueDate < date() 
                    %} overdue {% endif %}">
                    <td class="format-date">{{ homework.info.dueDate }}</td>
                    <td>{{ homework.info.title }}</td>
                    <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
                    <td>
                    {% if homework.status == 0 %}
                        {{ t._('not-started') }}
                    {% elseif homework.status == 1 %}
                        {{ t._('in-progress') }}
                    {% elseif homework.status == 2 %}
                        {{ t._('to-review') }}
                    {% else %}
                        {{ t._('reviewed') }}
                    {% endif %}
                    </td>
                    <td>
                    {% if homework.status != 2 %}
                        {{ link_to("teacher/homework/show/"~homework.id, "class":"btn-review btn-icon icon-eye-open", "title":t._("view")) }}
                    {% else %}
                        {{ link_to("teacher/homework/review/"~homework.id, "class":"btn-review btn-icon icon-eye-open", "title":t._("review")) }}
                        <span data-count="{{ homework.Files.count() }}" data-title="{{ homework.info.title }}" data-homework-id="{{ homework.id }}" class="btn-submit-review btn-icon icon-ok" title="Review"></span>
                    <td></td>
                    {% endif %}
                    </td>
                </tr>
            {% endfor %}
        {% endfor %}
        </tbody>
    </table>

    <ul class="pagination">
        <li>{{ link_to("teacher/homework/class/"~classId~"?page="~page.before~"&group=date",
        "class":"icon-chevron-left Prev") }}</li>
        {% for link in links %}
        <li>
            {{ link_to(link['url'], link['page']) }}
        </li>
        {% endfor %}
        <li>
            {{ link_to("teacher/homework/class/"~classId~"?page="~page.next~"&group=date",
                "class":"icon-chevron-right Next") }}</li>
        </li>
    </ul>
</div>
