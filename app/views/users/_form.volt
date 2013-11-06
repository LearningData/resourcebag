<div class="col-sm-6">
    <h2>{{ t._("Your Information") }}</h2>
    <label for="Type">{{ t._("type")}}</label>
    <select name="Type">
        <option value="T" selected="true">Teacher</option>
    </select>
    <label for="FirstName">{{ t._("name") }}</label>
    <div class="row">
        <div class="col-sm-6">
            {{ text_field("FirstName", "placeholder":t._("first")) }}
        </div>
        <div class="col-sm-6">
            {{ text_field("LastName", "placeholder":t._("lastname")) }}
        </div>
    </div>
    <label for="email">{{ t._("email") }}</label>
    {{ text_field("email", "placeholder":t._("email")) }}

    <label for="confirm-email">{{ t._("Confirm Email") }}</label>
    {{ text_field("confirm-email", "placeholder":t._("Confirm Email")) }}
    <div class="row">
        <div class="col-sm-6">
            <label for="password">{{ t._("password") }}</label>
            {{ password_field("password") }}
        </div>
        <div class="col-sm-6">
            <label for="password">{{ t._("Confirm Password") }}</label>
            {{ password_field("confirm-password") }}
        </div>
    </div>
</div>

<div class="col-sm-6 orange">

    <h2>{{ t._("Yours School Information") }}</h2>
    <label for="schoolID">{{ t._("School") }}</label>
    {{ select('schoolID', schools, 'using': ['id', 'name'],
    'emptyText': 'Please, choose one school') }}

    <label for="accessCode">{{ t._("Access Code") }}</label>
    {{ text_field("accessCode", "placeholder":t._("Access Code")) }}

    {{ hidden_field("userID", "type" : "numeric") }}
    {{ securityTag.csrf(csrf_params) }}

    {{ submit_button("Create Account", "class":"btn") }}
    </form>
</div>