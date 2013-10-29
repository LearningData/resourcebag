<div class="timetable red">
    <h1 class="header">Timetable</h1>
    <div class="nav">
        <a title="Prev" class="btn-prev"><span class="icon-chevron-sign-left"></span></a>
        <a title="Next" class="btn-next"><span class="icon-chevron-sign-right"></span></a>
        <div class="title"><h2></h2></div>
    </div>

    <table class="table week">
        <thead class="head">
            <tr>
                {% for day in period %}
                <th class="day-of-week" data-day="{{ day.format('N') }}">{{ day.format("l d") }}</th>
                {% endfor %}
            </tr>
        </thead>
    </table>
</div>
