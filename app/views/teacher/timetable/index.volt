<h1 class="timetable-header">Timetable</h1>
<div class="nav-timetable">
    <a title="Prev" class="nav-timetable-btn-prev"><span class="icon-chevron-sign-left"></span></a>
    <a title="Next" class="nav-timetable-btn-next"><span class="icon-chevron-sign-right"></span></a>
    <div class="nav-timetable-title"><h2></h2></div>
</div>

<table class="table table-timetable week">
    <thead class="table-head">
        <tr>
            {% for day in period %}
            <th class="timetable-day" data-day="{{ day.format('N') }}">{{ day.format("l d") }}</th>
            {% endfor %}
        </tr>
    </thead>
</table>
