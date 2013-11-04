<p class="col-sm-12">
    <label for="FirstName">First Name</label>
</p>
<p class="col-sm-6 col-md-6">
    {{ text_field("FirstName", "value" : user.name) }}
</p>
<p class="col-sm-6 col-md-6">
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
</form>
<p>
    {{ submit_button(t._("global.save"), "class":"btn") }}
    <button class="btn btn-cancel">
        {{ t._("global.cancel") }}
    </button>
</p>