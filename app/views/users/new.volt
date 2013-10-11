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
    <label>Year</label>
    <select name="year">
        <option value="-1">Juniors</option>
        <option value="0">Seniors</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
</p>

<p>
    <label>Type</label>
    {{ select('type', types, 'using': ['id', 'name'],
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
