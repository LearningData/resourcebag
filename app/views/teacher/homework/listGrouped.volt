<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
    </header>
    <table class="table table-hover week-view fixed">
        <thead>
            <tr>
                <th>{{ t._("due-date") }}</th>
                <th>{{ t._("title-label") }}</th>
                <th>{{ t._("pending") }}</th>
                <th>{{ t._("submitted") }}</th>
            </tr>
        </thead>
        <tbody>
        {% for item in page.items %}
            <tr class="week-group">
                <td class="format-date" data-date-special="week-begins">{{ item["start"] }}</td>
                <td></td><td></td><td></td>
            </tr>
            {% for homework in item["homeworks"] %}
                <tr>
                    <td class="format-date">{{ homework.dueDate }}</td>
                    <td>
                        {{ link_to("teacher/homework/list/"~homework.id,
                            homework.title) }}
                    </td>
                    <td>
                        {{ link_to("teacher/homework/list/"~homework.id~"&filter=3",
                            homework.submittedHomeworks()|length) }}
                    </td>
                    <td>
                        {{ link_to("teacher/homework/list/"~homework.id~"&filter=1",
                            homework.pendingHomeworks()|length) }}
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
