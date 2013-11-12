<div class="notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("edit-notice") }}</h2>
    </header>
    {{ form("notice/update", "method":"post", "class":"inline")}}
    {{ securityTag.csrf(csrf_params) }}
    <div class="col-md-9">
        {{ text_area('notice') }}
    </div>
    <div class="col-md-6">
        <div class="radio-box">
            {% for name, value in types %}
            {% if name == notice.userType %}
            <label> {{ radio_field("type", "checked": "true", "value": name) }} {{ value }} </label>
            {% else %}

            <label> {{ radio_field("type", "value": name) }} {{ value }} </label>

            {% endif %}
            {% endfor %}
        </div>
    </div>

    <div class="col-md-6">
        {{ select('class-id', classes) }}
    </div>

    {{ hidden_field("notice-id") }}
    <input type="submit" class="btn" value="{{ t._("save") }}">
    <button class="btn btn-return">
        {{ t._("cancel") }}
    </button>
    </form>
    

