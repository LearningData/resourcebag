<h2>{{ t._("resource-upload") }}</h2>
{{ form("resources/upload", "method":"post", "enctype":"multipart/form-data") }}
    <p>{{ t._("description") }}</p>
    <p>
        {{ text_area("description") }}
    </p>
    <p>{{ t._("subject") }}</p>
    <p>
        {{ select("subject-id", classes, 'using': ['id', 'value']) }}
    </p>
    <p>{{ t._("group") }} {{ link_to("resources/newTag", "New") }}</p>
    <p>
        {% for property in properties %}
            {{ check_field("tags[]", "value": property.id) }} {{ property.name }}
        {% endfor %}
    </p>
    <p>{{ t._("file") }}</p>
    <input type="file" name="file">
    {{ submit_button("Upload") }}
</form>