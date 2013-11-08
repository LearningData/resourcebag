<div class="notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("edit-notice") }}</h2>
    </header>
    {{ form("notice/update", "method":"post", "class":"inline")}}
        {{ securityTag.csrf(csrf_params) }}
        <p class="col-md-6">
            {{ text_area('notice') }}
        </p>
        <span class="col-md-6">
        <div class="radio-box form-control">
        {% for name, value in types %}
            {% if name == notice.userType %}
                <div><label>
                    {{ radio_field("type", "checked": "true", "value": name) }} {{ value }}
                </label></div>
            {% else %}
                <div><label>
                    {{ radio_field("type", "value": name) }} {{ value }}
                </label></div>
            {% endif %}
        {% endfor %}
        <p>             {{ select('class-id', classes) }}
        </p>
        {{ hidden_field("notice-id") }}
        <input type="submit" class="btn">
    </form>
    <button class="btn btn-return">{{ t._("cancel") }}</button>
</div>
