<h1 class="timetable-header">Timetable</h1>
<div class="nav-timetable">
    <a title="Prev" class="nav-timetable-btn-prev"><span>Prev</span></a>
    <a title="Next" class="nav-timetable-btn-next"><span>Next</span></a>
    <div class="nav-timetable-title"><h2></h2></div>
</div>

<table class="table table-timetable">
<!--    <thead class="table-head">
        <tr>
            {% for day in period %}
            <th class="timetable-day" data-day="{{ day.format('N') }}">{{ day.format("l d") }}</th>
            {% endfor %}
        </tr>
    </thead>
    <tbody>
        <tr>
            {% for daySlots in slots %}
            <td> {% for slot in daySlots %}
            <p>
                {{ slot["time"] }} {{ slot["subject"] }} {{ slot["room"] }} {{ slot["homeworks"] }}
            </p> {% endfor %} </td>
            {% endfor %}
        </tr>
    </tbody>-->
</table>
