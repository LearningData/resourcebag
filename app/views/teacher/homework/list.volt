<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
    </header>
    {% if classes %}

    <table class="table table-hover fixed">
        <thead>
            <tr>
                <th colspan=7>{{ t._("class") }}</th>
                <th></th>
                <th>{{ t._("students") }}</th>
                <th>{{ t._("set") }}</th>
                <th>{{ t._("in progress") }}</th>
                <th>{{ t._("completed") }}</th>
            </tr>
        </thead>
        <tbody>
        {% for classList in classes %}
            <tr>
                <td colspan=7>
                    {% if classList.getPendingHomework().count() + classList.getStartedHomework().count() + classList.getSubmittedHomework().count() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=0", classList.subject.name~" ("~classList.extraRef~") - "~classList.cohort.stage) }}
                    {% else %}
                        {{ classList.subject.name~" ("~classList.extraRef~") - "~classList.cohort.stage }}
                    {% endif %}
                </td>
                <td><a href="/schoolbag/teacher/homework/new/{{ classList.id }}"><span class="custom-icon-new-homework"></span>{{ t._("new") }} </a>
                    {% if classList.getSubmittedHomework().count() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=2", "   "~t._("correct")) }}
                    {% endif %}
                </td>
                <td>
            {% if classList.getPendingHomework().count() + classList.getStartedHomework().count() + classList.getSubmittedHomework().count() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=0", classList.users.count()) }}
                    {% else %}
                        {{ classList.users.count() }}
                    {% endif %}
                </td>
                <td>{{ classList.getPendingHomework().count() }}</td>
                <td>{{ classList.getStartedHomework().count() }}</td>
                <td>{{ classList.getSubmittedHomework().count() }}</td>
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
                    <td>{{ homework.title }}</td>
                    <td>{{ homework.setDate }}</td>
                    <td>{{ homework.dueDate }}</td>
                    {% if homework.isSubmitted() %}
                        <td>
                            {{ link_to("teacher/homework/review/"~homework.id, "Review") }}
                        </td>
                        <td>
                            <input type="checkbox"
                                name="ids[]" value="{{ homework.id }}">
                        </td>
                    {% else %}
                        <td>
                        {% if homework.isReviewed() %}
                            {{ link_to("teacher/homework/show/"~homework.id, "View") }}
                        {% else %}
                            {{ homework.getStatus() }}
                        {% endif %}
                        </td>
                        </td></td>
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
        <input type="submit" value="{{ t._('save') }}" class="btn btn-left">
        <button type="button" class="btn btn-return btn-cancel">{{ t._("cancel") }}</button>
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
                <td>{{ homework.title }}</td>
                <td>{{ homework.setDate }}</td>
                <td>{{ homework.dueDate }}</td>
                <td>
                    {{ homework.getStatus() }}
                </td>
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
    {% endif %}
</div>
