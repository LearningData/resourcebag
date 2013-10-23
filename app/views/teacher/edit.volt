<h1>Edit user</h1>

{{ form("teacher/update", "method":"post", "enctype":"multipart/form-data") }}
{% include "users/_update_form.volt" %}

<p>
    {{ link_to("student/changePassword/", "Change Password") }}
</p>
