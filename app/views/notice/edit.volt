<h2>Edit Notice</h2>

{{ form("notice/update", "method":"post") }}
    <p>
        {{ text_area('notice') }}
    </p>
    {% for name, value in types %}
        {% if name == notice.userType %}
            <p>
                {{ radio_field("type", "checked": "true", "value": name) }} {{ value }}
            </p>
        {% else %}
            <p>
                {{ radio_field("type", "value": name) }} {{ value }}
            </p>
        {% endif %}
    {% endfor %}
    <p>
        {{ select('class-id', classes, 'using': ['id', 'name']) }}
    </p>
    {{ hidden_field("notice-id") }}
    <input type="submit">
</form>