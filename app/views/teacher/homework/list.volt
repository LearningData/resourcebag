<div class="ld-homework orange">
    <h1 class="header">{{ t._("homework") }}</h1>
    {% if classes %}

    <table class="table table-hover fixed">
        <thead>
            <tr>
                <th colspan=7>{{ t._("class") }}</th>
                <th></th>
                <th>{{ t._("students") }}</th>
                <th>{{ t._("in progress") }}</th>
                <th>{{ t._("submitted") }}</th>
            </tr>
        </thead>
        <tbody>
        {% for classList in classes %}
            <tr>
                <td colspan=7>
                    {{ link_to("teacher/homework/class/"~classList.id~"?filter=3", classList.subject.name~" ("~classList.extraRef~") - "~classList.cohort.stage) }}
                </td>
                <td>{{ link_to("teacher/homework/new/"~classList.id, t._("new")) }}
                    {% if classList.getSubmittedHomework().count() %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=2", "   "~t._("correct")) }}
                    {% endif %}
                </td>
                <td>{{ link_to("teacher/homework/class/"~classList.id~"?filter=3", classList.users.count()) }}</td>
                <td>{{ classList.getPendingHomework().count() }}</td>
                <td>{{ classList.getSubmittedHomework().count() }}</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    {% else %}

    {{ form("homework/reviewManyHomeworks", "method":"post", "class":"form inline") }}
        <table class="table">
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
    </form>
    <button class="btn btn-return btn-cancel">{{ t._("cancel") }}</button>
    {% endif %}
</div>
