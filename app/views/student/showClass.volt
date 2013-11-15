<div class="ld-classes pink">
    <header>
        <h1 data-target="ld-classes">{{ t._("classes") }}</h1>
        <h2 class="subheader">{{ t._("viewing") }} - {{ classList.subject.name }}</h2>
    </header>

    <section>
        <h3>{{ classList.subject.name }}  <span class="h3"> with </span>Mr. {{ t._(classList.user.title) }}  {{ classList.user.lastName }} {{ classList.room }}</h3>
    </section>

    <section>
        <h3>{{ t._("timetable") }}</h3>
        <table class="col-sm-12 ld-classes-timetable">
            <tr>
                <th class="col-sm-2">Monday</th>
                <th class="col-sm-2">Tuesday</th>
                <th class="col-sm-2">Wednesday</th>
                <th class="col-sm-2">Thursday</th>
                <th class="col-sm-2">Friday</th>
                <th class="col-sm-2">Saturday</th>
            </tr>
            <tr>
                <td class="col-sm-2">09:00 - 09:25</td>
                <td class="col-sm-2">--</td>
                <td class="col-sm-2">09:00 - 09:25</td>
                <td class="col-sm-2">09:00 - 09:25</td>
                <td class="col-sm-2">--</td>
                <td class="col-sm-2">09:00 - 09:25</td>
            </tr>
        </table>
    </section>

    <section>
        <h3>{{ t._("homework") }}</h3>
        {% for homework in homeworks if homework.status == 0 %}
        <h6>{{ t._("pending") }}</h6>
        <table>
            <tr>
                <th class="col-sm-3">Title</th>
                <th class="col-sm-6">Description</th>
                <th class="col-sm-3">Overdue</th>
            </tr>
            {% for homework in homeworks if homework.status == 0 %}
            <tr>
                <td class="col-sm-3">{{ link_to("student/homework/start/"~homework.id, homework.title)  }}</td>
                <td class="col-sm-6"><span>{{ homework.text }}</span></td>
                <td class="col-sm-3">{{ homework.getDueDate(t._("dateformat")) }}</td>
            </tr>
            {% endfor %}
            {% break %}
            {% endfor %}
        </table>

        {% for homework in homeworks if homework.status == 1 %}
        <h6>{{ t._("in-progress") }}</h6>
        <table>
            <tr>
                <th class="col-sm-3">Title</th>
                <th class="col-sm-6">Description</th>
                <th class="col-sm-3">Overdue</th>
            </tr>
            {% for homework in homeworks if homework.status == 1 %}
            <tr>
                <td class="col-sm-3">{{ link_to("student/homework/edit/"~homework.id, homework.title)  }}</td>
                <td class="col-sm-6">{{ homework.text }}</td>
                <td class="col-sm-3">{{ homework.getDueDate(t._("dateformat")) }}</td>
            </tr>
            {% endfor %}
            {% break %}
            {% endfor %}
        </table>
    </section>

    <section>
        <h3>{{ t._("resources") }}</h3>
    </section>

</div>
