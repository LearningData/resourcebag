<div align="center">
    <h1>Edit user {{ schoolUser.name }} {{ schoolUser.lastName }}</h1>
</div>

{{ form("school/update", "method":"post", "enctype":"multipart/form-data") }}
<p>
    <label for="FirstName">First Name</label>
    {{ text_field("FirstName", "size" : 30, "value" : schoolUser.name) }}
</p>
<p>
    <label for="LastName">Last Name</label>
    {{ text_field("LastName", "size" : 30, "value" : schoolUser.lastName) }}
</p>
<p>
    <label for="email">Email</label>
    {{ text_field("email", "size" : 30, "value" : schoolUser.email) }}
</p>
<p>
    <label for="photo">Photo</label>
    {{ file_field("photo") }}
</p>
{{ hidden_field("userID", "type" : "numeric", "value" : schoolUser.id) }}
<p>
    {{ submit_button("Save") }}
</p>
</form>