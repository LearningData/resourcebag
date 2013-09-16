{% include "teacher/_header.volt" %}

<h1>Timetable</h1>

{% for slot in slots %}
    <p>{{ slot }}</p>
{% endfor %}