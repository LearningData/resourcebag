<div class="ld-classes pink">
    <header>
        <h1 data-target="ld-classes">{{ t._("classes") }}</h1>
        <h2 class="subheader">{{ t._("viewing") }} - {{ classList.subject.name }}</h2>
    </header>

    <section>
        <h3>{{ classList.subject.name }}  <span class="h3"> {{ t._("with") }} </span>{{ t._(classList.user.title) }}  {{ classList.user.lastName }} {{ classList.getRooms() }}</h3>
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
            {% for i in 1..6  %}
                <td class="col-sm-2">
                {% set day = classList.getSlotIdsByDay(i) %}
                {% if day|length == 0 %}
                    --
                {% else %}
                    {% for index in 0..day|length %}
                       {{ day[index] }} <br>
                    {% endfor %}
                {% endif %}
                </td>
            {% endfor %}
            </tr>
        </table>
    </section>

    <section class="homework">
        <h3>{{ t._("homework") }}
       <a href="/schoolbag/student/homework/class/{{ classList.id}}" +  class="view-all">
    <span class="custom-icon-homework"></span>{{ t._("view-all") }}
    </a></h3>
        {% if homeworks|length > 0 %}
        <table>
            <tr>
                <th class="col-sm-3"></th>
                <th class="col-sm-6">{{ t._("description") }}</th>
                <th class="col-sm-3">{{ t._("date") }}</th>
            </tr>
            {% for homework in homeworks if homework.status == 0 %}
            <tr><td colSpan=3 class="status-header h6">{{ t._("pending") }}</td></tr>
            {% break %}
            {% endfor %}
            {% for homework in homeworks if homework.status == 0 %}
            <tr>
                <td class="col-sm-3">
                    {{ link_to("student/homework/start/"~homework.id,
                        homework.info.title)  }}
                </td>
                <td class="col-sm-6"><span>{{ homework.info.text }}</span></td>
                <td class="col-sm-3">{{ homework.info.getDueDate(t._("dateformat")) }}</td>
            </tr>
            {% endfor %}
            {% for homework in homeworks if homework.status == 1 %}
            <tr><td colSpan=3 class="status-header h6">{{ t._("to-do") }}</td></tr>
            {% break %}
            {% endfor %}
            {% for homework in homeworks if homework.status == 1 %}
            <tr>
                <td class="col-sm-3">
                    {{ link_to("student/homework/do/"~homework.id,
                        homework.info.title)  }}
                </td>
                <td class="col-sm-6">{{ homework.info.text }}</td>
                <td class="col-sm-3">{{ homework.info.getDueDate(t._("dateformat")) }}</td>
            </tr>
            {% endfor %}
        </table>
        {% endif %}
    </section>

    <section>
        <h3>{{ t._("resources") }}</h3>
    </section>

</div>
