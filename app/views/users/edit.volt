<div class="orange">
    <header>
        <h1>{{ t._("profile") }}</h1>
    </header>
    {{ form(user.getController()~"/update", "method":"post",
    "enctype":"multipart/form-data") }}
    {% include "users/_update_form.volt" %}
</div>