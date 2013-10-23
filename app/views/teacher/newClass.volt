<h1>New Class</h1>

{{ form("teacher/createClass", "method":"post", "class":"form-tmtbl") }}
    <p class="col-md-6">
        <label for="subject-id">Subject</label>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one subject', "class":"customSelect") }}
    </p>
    <p class="col-md-6">
        <label for="cohort-id">Cohort</label>
        {{ select('cohort-id', cohorts, 'using': ['id', 'stage'],
                'emptyText': 'Please, choose one cohort') }}
    </p>
    <p class="col-md-6">
        <input placeholder="Room" type="text" name="room">
    </p>
    <p class="col-md-6">
        <input placeholder="Extra Ref" type="text" name="extra-ref">
    </p>

    <h2>Slots</h2>
    <table class="table table-condensed table-timetable">
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
                {% for index, daySlots in slots %}
                    {% set name = index %}
                    <td>
                    {% for slot in daySlots %}
                        <p>
                            <input type="checkbox"
                                name="day{{ name }}[]"
                                value="{{ slot.timeSlotId }}"> {{ slot.startTime }}
                        </p>
                    {% endfor %}
                    </td>
                {% endfor %}
            </tr>
        </tbody>
    </table>
    <input type="submit" class="btn">
</form>
