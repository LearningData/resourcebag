{% include "teacher/_header.volt" %}

<h1>Timetable</h1>

<table class="table table-condensed">
    <thead>
        <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            {% for daySlots in slots %}
                <td>
                {% for slot in daySlots %}
                    <p>{{ slot }}</p>
                {% endfor %}
                </td>
            {% endfor %}
        </tr>
    </tbody>
</table>