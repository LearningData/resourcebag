<h2>{{ t._("resource-upload") }}</h2>
{{ form("resources/createTag", "method":"post") }}
    <p>{{ t._("tag") }}</p>
    <p>
        {{ text_field("name") }}
    </p>
    {{ submit_button("Save") }}
</form>