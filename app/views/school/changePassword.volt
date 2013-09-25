<h1>Change your password</h1>

{{ form("school/updatePassword", "method":"post") }}
    {% include "users/_password_fields.volt" %}
</form>