{% include "school/_header.volt" %}

<h1>Timetable</h1>

<form action="/schoolbag/school/createSlot" method="post">
    <p>
        <label>Start Time</label>
        {{ select("start-hour", hours, 'using': ['id', 'value']) }}
        {{ select("start-minutes", minutes, 'using': ['id', 'value']) }}
    </p>
    <p>
        <label>End Time</label>
        {{ select("end-hour", hours, 'using': ['id', 'value']) }}
        {{ select("end-minutes", minutes, 'using': ['id', 'value']) }}
    </p>
    <p>
        <label>Preset</label>
        <input type="text" name="preset">
    </p>
    <p>
        <label>Day of Week</label>
        {{ select("week-day", weekDays, 'using': ['id', 'value']) }}
    </p>
    <p>
        <input type="submit">
    </p>
</form>

<h1>Slots</h1>

{% for slot in slots %}
    <p>{{ slot.startTime }} - {{ slot.endTime }}</p>
{% endfor %}