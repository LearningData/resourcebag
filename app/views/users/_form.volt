<div class="col-sm-6">
    <h2>Your's Information</h2>
    <label for="Type">{{ t._("type")}}</label>
    <select name="Type">
        <option value="T" selected="true">Teacher</option>
    </select>

    <label for="FirstName">{{ t._("name") }}</label>
    {{ text_field("FirstName", "size" : 30) }}

    <label for="LastName">{{ t._("lastname") }}</label>
    {{ text_field("LastName", "size" : 30) }}

    <label for="email">{{ t._("email") }}</label>
    {{ text_field("email", "size" : 30) }}

    <label for="confirm-email">Confirm {{ t._("email") }}</label>
    {{ text_field("confirm-email", "size" : 30) }}

    <label for="password">{{ t._("password") }}</label>
    {{ password_field("password", "size" : 30) }}

    <label for="confirm-password">Confirm {{ t._("password") }}</label>
    {{ password_field("confirm-password", "size" : 30) }}
</div>
<div class="col-sm-6">
    <h2>Your's School Information</h2>

    <label for="schoolID">School</label>
    {{ select('schoolID', schools, 'using': ['id', 'name'],
    'emptyText': 'Please, choose one school') }}

    <label for="accessCode">Access Code</label>
    {{ text_field("accessCode", "size" : 30) }}

    {{ hidden_field("userID", "type" : "numeric") }}
    {{ securityTag.csrf(csrf_params) }}

    {{ submit_button("Save") }}
    </form>
</div>