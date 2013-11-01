<p>
    <label for="FirstName">First Name</label>
    {{ text_field("FirstName", "value" : user.name) }}
</p>
<p>
    <label for="LastName">Last Name</label>
    {{ text_field("LastName", "value" : user.lastName) }}
</p>
<p>
    <label for="email">Email</label>
    {{ text_field("email", "value" : user.email) }}
</p>
<p>
    <label for="photo">Photo</label>
    {{ file_field("photo") }}
</p>
{{ hidden_field("userID", "type" : "numeric", "value" : user.id) }}
{{ securityTag.csrf(csrf_params) }}
<p>
    {{ submit_button("Save") }}
</p>
</form>