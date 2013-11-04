<div class="orange">
    <h1>{{ t._("Change your password") }}</h1>
    {{ form(user.getController()~"/updatePassword", "method":"post") }}
    {% include "users/_password_fields.volt" %}
</div>