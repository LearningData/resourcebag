<p class="col-sm-6 col-md-6">
    <label for="FirstName">{{ t._("user.name") }}</label>
    {{ text_field("FirstName", "value" : user.name) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="LastName">{{ t._("user.lastname") }}</label>
    {{ text_field("LastName", "value" : user.lastName) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="email">{{ t._("user.email") }}</label>
    {{ text_field("email", "value" : user.email) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="photo">{{ t._("user.photo") }}</label>
    {{ file_field("photo") }}
</p>
{{ hidden_field("userID", "type" : "numeric", "value" : user.id) }}
{{ securityTag.csrf(csrf_params) }}
</form>
<p>
    {{ submit_button(t._("save"), "class":"btn") }}
    <button class="btn btn-cancel">{{ t._("cancel") }}</button>
</p>