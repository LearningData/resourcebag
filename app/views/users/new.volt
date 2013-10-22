<h1>Create User</h1>

{{ form("users/create", "method":"post", "enctype":"multipart/form-data") }}
<p>
    <label>Name</label>
    {{ text_field("name") }}
</p>

<p>
    <label>Last Name</label>
    {{ text_field("last-name") }}
</p>

<p>
    <label>Email</label>
    {{ text_field("email") }}
</p>

<p>
    <label>Type</label>
    {{ select('type', types, 'using': ['id', 'name'],
         'emptyText': 'Please, choose one type') }}
</p>

<p>
    <label>Cohort</label>
    {{ select('group-id', cohorts, 'using': ['groupId', 'stage'],
         'emptyText': 'Please, choose one type') }}
</p>

<p>
    <label>Password</label>
    {{ password_field("password") }}
</p>

<p>
    <label>Confirm Password</label>
    {{ password_field("confirm-password") }}
</p>

<p>
    <label>Photo</label>
    {{ file_field("photo") }}
</p>
<p>
    {{ submit_button("Create") }}
</p>

</form>
