<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }} - {{ homework.title }}</h1>
    </header>
    <table class="table table-hover week-view fixed">
        <thead>
            <tr>
                <th>{{ t._("due-date") }}</th>
                <th>{{ t._("student") }}</th>
                <th>{{ t._("action") }}</th>
                <th>{{ t._("status") }}</th>
            </tr>
        </thead>
        <tbody>
        {% for work in page.items %}
        <tr>
            <td>{{ homework.getDueDate() }}</td>
            <td>{{ work.student.completeName() }}</td>
            <td>action</td>
            <td>{{ work.getStatus() }}</td>
        </tr>
        {% endfor %}
        </tbody>
    </table>
    {% if page.total_pages > 1 %}
    <ul class="pagination">
        <li>{{ link_to("teacher/homework/list/"~homework.id~"?page="~page.before~"&filter="~status,
        "class":"icon-chevron-left Prev") }}</li>
        {% for link in links %}
        <li>
            {{ link_to(link['url'], link['page']) }}
        </li>
        {% endfor %}
        <li>
            {{ link_to("teacher/homework/list/"~homework.id~"?page="~page.next~"&filter="~status,
                "class":"icon-chevron-right Next") }}</li>
        </li>
    </ul>
    {% endif %}
</div>