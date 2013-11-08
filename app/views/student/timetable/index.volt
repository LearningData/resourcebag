<div class="ld-timetable red">
    <header>
        <h1>{{ t._("timetable")}}</h1>
    </header>
    <div class="ld-responsive-sm">
        <div class="nav">
            <a title="Prev" class="btn-prev"><span class="icon-chevron-sign-left"></span></a>
            <a title="Next" class="btn-next"><span class="icon-chevron-sign-right"></span></a>
            <div class="title">
                <h2></h2>
            </div>
        </div>
        <table class="table week">
            <thead class="head">
                <tr>
                    {% for day in period %}
                    <th class="day-of-week" data-day="{{ day.format('N') }}">{{ day.format("l") }}</th>
                    {% endfor %}
                </tr>
            </thead>
        </table>
    </div>
    <div class="ld-responsive-xs">
        <div class="nav">
            <a title="Prev" class="btn-prev"><span class="icon-chevron-sign-left"></span></a>
            <a title="Next" class="btn-next"><span class="icon-chevron-sign-right"></span></a>
            <div class="title">
                <h2></h2>
            </div>
        </div>
        <table class="table"></table>
    </div>
</div>
