<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
    </header>
    <section class="ld-subsection first">
        <h3 class="subheader">{{ classList.subject.name }}</h3>
        <p class="col-md-6">
            <span class="label">{{ t._("teacher") }}</span>
            {{ classList.user.name }}   {{ classList.user.lastName }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("cohort") }}</span>
            {{ classList.cohort.stage }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("room") }}</span>
            {{ classList.getRooms() }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("extra-ref") }}</span>
            {{ classList.extraRef }}
        </p>
        <hr/>
    </section>
    <section>
        <h3>{{ t._("timetable") }}</h3>
        <table class="col-sm-12 ld-classes-timetable">
            <tr>
                <th class="col-sm-2">{{ t._("monday") }}</th>
                <th class="col-sm-2">{{ t._("tuesday") }}</th>
                <th class="col-sm-2">{{ t._("wednesday") }}</th>
                <th class="col-sm-2">{{ t._("thursday") }}</th>
                <th class="col-sm-2">{{ t._("friday") }}</th>
                <th class="col-sm-2">{{ t._("saturday") }}</th>
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
    <section class="ld-subsection first">
        <h3>{{ t._("resources") }}</h3>
        <p>
            Here is where you can add/find links to material and web services of use in the class.
        </p>
    </section>
    <section class="ld-subsection first student-list">
        <h3>{{ t._("students") }}</h3>
        <input class="filter" type="text" placeholder="Filter student list">
        {% for student in classList.users %}
        <p class="col-xs-3">
            {{ student.name }} {{ student.lastName }}
        </p>
        {% endfor %}
    </section>
    <div class="clearfix"></div>
</div>
