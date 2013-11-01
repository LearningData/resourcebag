<h1>Profile</h1>
{{ form("student/update", "method":"post", "enctype":"multipart/form-data") }}
{% include "users/_update_form.volt" %}

<p>
    {{ link_to("student/changePassword/", "Change Password", "class":"btn") }}
</p>
