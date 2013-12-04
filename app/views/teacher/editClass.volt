<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
        <h2>{{ t._("edit-class") }}</h1>
    </header>
    {{ form("teacher/updateClass", "method":"post", "class":"form-inline") }}
        <p class="col-md-6">
            <label>{{ t._("room") }}</label>
            <input placeholder={{ t._("room") }} type="text" name="room"
                class="form-control" value="{{ room }}">
        </p>
        <p class="col-md-6">
            <label for="extra-ref">{{ t._("extra-ref") }}</label>
            <input placeholder="Extra Ref" type="text" name="extra-ref"
                class="form-control" value="{{ classList.extraRef }}">
        </p>
        <input type="hidden" name="class-id" value="{{ classList.id }}">

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
                    <td>
                        {% for slot in daySlots %}
                        {% set config = slot["config"] %}
                        <p>
                            {% if slot["checked"] %}
                                <input type="checkbox" name="day{{ name }}[]"
                                    value="{{ config.timeSlotId }}" checked="true">
                                {{ config.startTime }}
                            {% else %}
                                <input type="checkbox" name="day{{ name }}[]"
                                    value="{{ config.timeSlotId }}">
                                {{ config.startTime }}
                            {% endif %}
                        </p>
                        {% endfor %}
                    </td>
                    {% endfor %}
                </tr>
            </tbody>
        </table>
        <div class="mtop-20">
            {{ submit_button(t._("save"),"class":"btn") }}
            <button type="button" class="btn btn-return btn-cancel">
                {{ t._("cancel") }}
            </button>
        </div>
    </form>

</div>
