<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
    </header>
    {% if classes is defined %}

    <table class="table table-hover fixed">
        <thead>
            <tr>
                <th colspan=7>{{ t._("class") }}</th>
                <th></th>
                <th>{{ t._("students") }}</th>
                <th>{{ t._("set") }}</th>
                <th>{{ t._("in-progress") }}</th>
                <th>{{ t._("completed") }}</th>
            </tr>
        </thead>
        <tbody>
            {% for classList in classes %}
            <tr>
                <td colspan=7>
                    {% if classList.getSubmittedHomework() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=2", classList.subject.name~" ("~classList.extraRef~") - "~classList.cohort.stage) }}
                    {% else %}
                        {{ classList.subject.name~" ("~classList.extraRef~") - "~classList.cohort.stage }}
                    {% endif %}
                </td>
                <td class="ld-new-buttons"><a href="/schoolbag/teacher/homework/new/{{ classList.id }}"><span class=" custom-icon-new-homework"></span>{{ t._("new") }} </a>
                    {% if classList.getSubmittedHomework() %}
                        <a href="/schoolbag/teacher/homework/class/{{ classList.id }}?filter=2"><span class="icon-ok-circle"></span>{{ t._("correct") }} </a>
                    {% endif %}
                </td>
                <td class="ld-student-status">
            {% if classList.getSubmittedHomework() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=2", classList.users.count()) }}
                    {% else %}
                        {{ classList.users.count() }}
                    {% endif %}
                </td>
                <td>{{ classList.getPendingHomework()|length }}</td>
                <td>{{ classList.getStartedHomework()|length }}</td>
                <td>{{ classList.getSubmittedHomework()|length }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>

    {% elseif status == 2 %}
    {{ form("homework/reviewManyHomeworks", "method":"post", "class":"form") }}
    <table class="table {{ status }}">
        <thead>
            <tr>
                <th>{{ t._("student") }}</th>
                <th>{{ t._("homework title") }}</th>
                <th>{{ t._("assigned date") }}</th>
                <th>{{ t._("due date") }}</th>
                <th>{{ t._("action") }}</th>
                <th>{{ t._("review") }}</th>
            </tr>
        </thead>
        <tbody>
            {% for homework in page.items %}
            <tr>
                <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
                <td>{{ homework.info.title }}</td>
                <td>{{ homework.info.setDate }}</td>
                <td>{{ homework.info.dueDate }}</td>
                {% if homework.isSubmitted() %}
                <td> {{ link_to("teacher/homework/review/"~homework.id, "class":"btn-review btn-icon icon-eye-open", "title":t._("review")) }} </td>
                <td>
                <input type="checkbox"
                name="ids[]" value="{{ homework.id }}">
                </td>
                {% else %}
                <td> {% if homework.isReviewed() %}
                {{ link_to("teacher/homework/show/"~homework.id, "View") }}
                {% else %}
                {{ homework.getStatus() }}
                {% endif %} </td>
                </td></td>
                {% endif %}
            </tr>
            {% endfor %}
        </tbody>
    </table>
    <ul class="paginator homework">
        <li>
            {{ link_to("teacher/homework?page="~page.before~"&filter="~status, "class":"icon-chevron-left Prev") }}
        </li>
        {% for link in links %}
        <li>
            {{ link_to(link['url'], link['page']) }}
        </li>
        {% endfor %}
        <li>
            {{ link_to("teacher/homework?page="~page.next~"&filter="~status, "class":"icon-chevron-right Next") }}
        </li>
        </li>
    </ul>
    <input type="submit" value="{{ t._('save') }}" class="btn btn-left">
    <button type="button" class="btn btn-return btn-cancel">
        {{ t._("cancel") }}
    </button>
    </form>
    {% else %}
    <table class="table">
        <thead>
            <tr>
                <th>{{ t._("student") }}</th>
                <th>{{ t._("homework title") }}</th>
                <th>{{ t._("assigned date") }}</th>
                <th>{{ t._("due date") }}</th>
                <th>{{ t._("status") }}</th>
            </tr>
        </thead>
        <tbody>
            {% for homework in page.items %}
            <tr>
                <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
                <td>{{ homework.info.title }}</td>
                <td>{{ homework.info.getSetDate(t._("dateformat")) }}</td>
                <td>{{ homework.info.getDueDate(t._("dateformat")) }}</td>
                <td> {{ homework.getStatus() }} </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
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
    {% endif %}
</div>
