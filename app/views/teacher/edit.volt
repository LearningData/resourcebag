<h1>Edit user</h1>

{{ form("teacher/update", "method":"post", "enctype":"multipart/form-data") }}
{% include "users/_update_form.volt" %}

<p>
    {{ link_to("teacher/changePassword/", "Change Password") }}
</p>
