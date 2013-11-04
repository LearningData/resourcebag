<<<<<<< HEAD
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
=======
<div class="col-sm-6">
    <h2>Your's Information</h2>
    <label for="Type">{{ t._("user.type")}}</label>
    <select name="Type">
        <option value="T" selected="true">Teacher</option>
    </select>

    <label for="FirstName">{{ t._("user.name") }}</label>
    {{ text_field("FirstName", "size" : 30) }}

    <label for="LastName">{{ t._("user.lastname") }}</label>
    {{ text_field("LastName", "size" : 30) }}

    <label for="email">{{ t._("user.email") }}</label>
    {{ text_field("email", "size" : 30) }}

    <label for="confirm-email">Confirm {{ t._("user.email") }}</label>
    {{ text_field("confirm-email", "size" : 30) }}

    <label for="password">{{ t._("user.password") }}</label>
    {{ password_field("password", "size" : 30) }}

    <label for="confirm-password">Confirm {{ t._("user.password") }}</label>
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
>>>>>>> 3db67443ba5fdf393fcf7177d9cad1743cc030e6
</div>