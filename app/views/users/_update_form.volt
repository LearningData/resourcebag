{% if user.isTeacher() %}
<div class="col-sm-6">
    <label>{{ t._("teacher-title") }}</label>
    {{ select('title', titles, 'using': ['id', 'name'],
    'emptyText': 'Please, choose one type') }}
</div>
{% endif %}

<p class="col-sm-6 col-md-6">
    <label for="FirstName">{{ t._("name") }}</label>
    {{ text_field("FirstName", "value" : user.name) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="LastName">{{ t._("lastname") }}</label>
    {{ text_field("LastName", "value" : user.lastName) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="email">{{ t._("email") }}</label>
    {{ text_field("email", "value" : user.email) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="photo">{{ t._("photo") }}</label>
    {{ file_field("photo") }}
</p>
{{ hidden_field("userID", "type" : "numeric", "value" : user.id) }}
{{ securityTag.csrf(csrf_params) }}
<p>
    {{ submit_button(t._("save"), "class":"btn") }}
    <button class="btn btn-cancel">{{ t._("cancel") }}</button>
</p>
</form>