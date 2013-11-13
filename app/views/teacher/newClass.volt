<div class="classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
        <h2>{{ t._("new-class") }}</h1>
    </header>
    {{ form("teacher/createClass", "method":"post", "class":"form-inline") }}
    <p class="col-md-6">
        <label for="subject-id">{{ t._("subject") }}</label>
        {{ select('subject-id', subjects, 'using': ['id', 'name'], "useEmpty":true,
        'emptyText': t._('choose-subject'), "class":"form-control") }}
    </p>
    <p class="col-md-6">
        <label for="cohort-id">{{ t._("cohort") }}</label>
        {{ select('cohort-id', cohorts, 'using': ['id', 'stage'], "useEmpty":true,
        'emptyText': t._('choose-cohort'), "class":"form-control") }}
    </p>
    <p class="col-md-6">
        <label>{{ t._("room") }}</label>
        <input placeholder={{ t._("room") }} type="text" name="room" class="form-control">
    </p>
    <p class="col-md-6">
        <label for="extra-ref">{{ t._("extra-ref") }}</label>
        <input placeholder="Extra Ref" type="text" name="extra-ref" class="form-control">
    </p>

    <h2>{{ t._("slots") }}</h2>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>{{ t._("monday") }}</th>
                <th>{{ t._("tuesday") }}</th>
                <th>{{ t._("wednesday") }}</th>
                <th>{{ t._("thursday") }}</th>
                <th>{{ t._("friday") }}</th>
                <th>{{ t._("saturday") }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {% for index, daySlots in slots %}
                {% set name = index %}
                <td> {% for slot in daySlots %}
                <p>
                    <input type="checkbox"
                    name="day{{ name }}[]"
                    value="{{ slot.timeSlotId }}">
                    {{ slot.startTime }}
                </p> {% endfor %} </td>
                {% endfor %}
            </tr>
        </tbody>
    </table>
    <div class="mtop-20">
        {{ submit_button(t._("save"),"class":"btn") }}
        <button class="btn btn-return btn-cancel">
            {{ t._("cancel") }}
        </button>
    </div>
    </form>

</div>
