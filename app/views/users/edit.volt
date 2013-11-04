<div class="orange">
    <h1>Profile</h1>
    {{ form(user.getController()~"/update", "method":"post",
        "enctype":"multipart/form-data") }}
    {% include "users/_update_form.volt" %}
</div>