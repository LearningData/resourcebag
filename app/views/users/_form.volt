<div class="row">
    <div class="col-sm-6">
        <h2>Your's Information</h2>

        <label for="Type">{{ t._("type")}}</label>
        <select name="Type">
            <option value="T" selected="true">Teacher</option>
        </select>

        <div class="row">
            <div class="col-sm-12">
                <label for="FirstName">{{ t._("name") }}</label>
            </div>

            <div class="col-sm-6">
                {{ text_field("FirstName", "placeholder":t._("firstname")) }}
            </div>
            <div class="col-sm-6">
                {{ text_field("LastName", "placeholder":t._("lastname")) }}
            </div>
        </div>

        <label for="email">{{ t._("email") }}</label>
        {{ text_field("email", "placeholder":t._("email")) }}

        <label for="confirm-email">{{ t._("confirmemail") }}</label>
        {{ text_field("confirm-email", "placeholder":t._("confirmemail")) }}

        <div class="row">
            <div class="col-sm-12">
                <label for="password">{{ t._("password") }}</label>
            </div>

            <div class="col-sm-6">
                {{ password_field("password", "placeholder":t._("password")) }}
            </div>
            <div class="col-sm-6">
                {{ password_field("confirm-password", "placeholder":t._("confirmpassword")) }}
            </div>
        </div>

    </div>
    <div class="col-sm-6 orange">
        <h2>Your's School Information</h2>

        <label for="schoolID">School</label>
        {{ select('schoolID', schools, 'using': ['id', 'name'],
        'emptyText': 'Please, choose one school') }}

        <label for="accessCode">Access Code</label>
        {{ text_field("accessCode") }}

        {{ hidden_field("userID", "type" : "numeric") }}
        {{ securityTag.csrf(csrf_params) }}

        {{ submit_button("Create Account", "class":"btn") }}
        </form>
    </div>
</div>