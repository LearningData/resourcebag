{% include "teacher/_header.volt" %}

<h1>New Class</h1>

<form action="/schoolbag/teacher/createClass" method="post">
    <p>
        <label for="subject-id">Subject</label>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one subject') }}
    </p>
    <p>
        <label for="year">Year</label>
        <input type="text" name="year">
    </p>
    <p>
        <label for="extra-ref">Extra Ref</label>
        <input type="text" name="extra-ref">
    </p>
    <p>
        <label for="schyear">School Year: {{ schoolYear.value }}</label>
        <input type="hidden" name="schyear" value="{{ schoolYear.value }}">
    </p>

    <h2>Slots</h2>
    <section>
        <div id="monday">
            <h3>monday</h3>
            {% for slot in slots[2] %}
                <p>
                    <input type="checkbox"
                                name="day2[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
        <div id="tuesday">
            <h3>tuesday</h3>
            {% for slot in slots[3] %}
                <p>
                    <input type="checkbox"
                                name="day3[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
        <div id="wednesday">
            <h3>wednesday</h3>
            {% for slot in slots[4] %}
                <p>
                    <input type="checkbox"
                                name="day4[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
        <div id="thursday">
            <h3>thursday</h3>
            {% for slot in slots[5] %}
                <p>
                    <input type="checkbox"
                                name="day5[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
        <div id="friday">
            <h3>friday</h3>
            {% for slot in slots[6] %}
                <p>
                    <input type="checkbox"
                                name="day6[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
        <div id="saturday">
            <h3>saturday</h3>
            {% for slot in slots[7] %}
                <p>
                    <input type="checkbox"
                                name="day7[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                </p>
            {% endfor %}
        </div>
    </section>
    <input type="submit">
</form>