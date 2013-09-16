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
    <table>
        <thead>
            <tr>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
            </tr>
        </thead>
        <tbody>
            {% for slot in mondaySlots %}
                <tr>
                    <td>
                        <input type="checkbox"
                            name="monday[]"
                            value="{{ slot.id }}"> {{ slot.startTime }}
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>

    <input type="submit">
</form>