<p class="col-sm-6 col-md-6">
    <label for="FirstName">First Name</label>
    {{ text_field("FirstName", "value" : user.name) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="LastName">Last Name</label>
    {{ text_field("LastName", "value" : user.lastName) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="email">Email</label>
    {{ text_field("email", "value" : user.email) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="photo">Photo</label>
    {{ file_field("photo") }}
</p>
{{ hidden_field("userID", "type" : "numeric", "value" : user.id) }}
{{ securityTag.csrf(csrf_params) }}
<p>
    {{ submit_button("Save", "class":"btn") }}
    {{ link_to("student/changePassword/", "Change Password", "class":"btn") }}
</p>
</form>