<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homeworks") }}</h1>
    </header>
    {{ form("homework/reviewManyHomeworks", "method":"post", "class":"form") }}
    {% for item in page.items %}
        <h5>{{ item["week"] }}</h5>
        {% for homework in item["homeworks"] %}
            <p>
                {{ homework.info.title }} - {{ homework.student.name }}
                {{ homework.student.lastName }} - {{ homework.info.classList.subject.name }}
                - {{ homework.info.dueDate }}
            </p>
        {% endfor %}
    {% endfor %}
    <ul class="paginator homework">
        <li>{{ link_to("teacher/homework/class/"~classId~"?page="~page.before~"&filter="~status,
        "class":"icon-chevron-left Prev") }}</li>
        {% for link in links %}
        <li>
            {{ link_to(link['url'], link['page']) }}
        </li>
        {% endfor %}
        <li>
            {{ link_to("teacher/homework/class/"~classId~"?page="~page.next~"&filter="~status,
                "class":"icon-chevron-right Next") }}</li>
        </li>
    </ul>
</div>