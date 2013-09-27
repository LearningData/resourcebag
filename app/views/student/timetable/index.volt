<h1>Timetable</h1>

<table class="table table-condensed">
    <thead>
        <tr>
            {% for day in period %}
                <th>{{ day.format("l d") }}</th>
            {% endfor %}
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