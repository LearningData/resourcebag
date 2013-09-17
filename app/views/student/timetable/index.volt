{% include "student/_header.volt" %}

<h1>Timetable</h1>

<section>
    <div id="monday">
        <h3>monday</h3>
        {% for slot in slots[2] %}
            <p>{{ slot }}</p>
        {% endfor %}
    </div>
    <div id="tuesday">
        <h3>tuesday</h3>
            {% for slot in slots[3] %}
                <p>{{ slot }}</p>
            {% endfor %}
    </div>
    <div id="wednesday">
        <h3>wednesday</h3>
        {% for slot in slots[4] %}
            <p>{{ slot }}</p>
        {% endfor %}
    </div>
    <div id="thursday">
        <h3>thursday</h3>
            {% for slot in slots[5] %}
                <p>{{ slot }}</p>
            {% endfor %}
    </div>
    <div id="friday">
        <h3>friday</h3>
            {% for slot in slots[6] %}
                <p>{{ slot }}</p>
            {% endfor %}
    </div>
    <div id="saturday">
        <h3>saturday</h3>
            {% for slot in slots[7] %}
                <p>{{ slot }}</p>
            {% endfor %}
    </div>
</section>