<div class="orange">
    <header>
        <h1>{{ t._("Change your password") }}</h1>
    </header>
    {{ form(user.getController()~"/updatePassword", "method":"post") }}
    {% include "users/_password_fields.volt" %}
</div>