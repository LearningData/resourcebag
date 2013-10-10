<h2>Edit Notice</h2>

{{ form("notice/update", "method":"post") }}
    <p>
        {{ text_area('notice') }}
    </p>
    {% if notice.userType == "P" %}
    <p>
        {{ radio_field("type", "checked": "true", "value": "P") }} Teachers/Students
    </p>
    <p>
        {{ radio_field("type", "value": "T") }} Teachers
    </p>
    {% else %}
    <p>
        {{ radio_field("type", "value": "P") }} Teachers/Students
    </p>
    <p>
        {{ radio_field("type", "checked": "true", "value": "T") }} Teachers
    </p>
    {% endif %}
    <p>
        {{ select('class-id', classes, 'using': ['id', 'name']) }}
    </p>
    {{ hidden_field("notice-id") }}
    <input type="submit">
</form>