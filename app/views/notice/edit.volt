<div class="notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("edit-notice") }}</h2>
    </header>
    {{ form("notice/update", "method":"post", "class":"inline")}}
    {{ securityTag.csrf(csrf_params) }}
    <h3>{{ t._("edit-notice") }}</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="radio-box mtop-20">
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
        <div class="clearfix"></div>
        <div class="col-md-12">
            {{ text_area('notice', "rows":"15") }}
        </div>
        <p class="col-md-6">
            <label>{{ t._("notice-category") }}</label>
            {{ select('category', categories, 'using': ['id', 'name'], "class":"form-control") }}
        </p>
        {{ hidden_field("notice-id") }}
    </div>

    <input type="submit" class="btn" value="{{ t._("save") }}">
    <button class="btn btn-return btn-cancel" type="button">
        {{ t._("cancel") }}
    </button>

    </form>

