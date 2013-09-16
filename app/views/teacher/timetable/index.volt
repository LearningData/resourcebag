{% include "teacher/_header.volt" %}

<h1>Timetable</h1>

<section>
    <div id="monday">
        <h3>monday</h3>
        {% for slot in slots %}
            <p>{{ slot }}</p>
        {% endfor %}
    </div>
    <div id="tuesday">
        <h3>tuesday</h3>
    </div>
</section>