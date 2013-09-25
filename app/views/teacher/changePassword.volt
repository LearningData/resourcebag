<h1>Change your password</h1>
{{ form("teacher/updatePassword", "method":"post") }}
    {% include "users/_password_fields.volt" %}
</form>