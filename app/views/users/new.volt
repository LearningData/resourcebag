<div class="orange">
    <header>
        <h1>{{ t._("create-user") }}</h1>
    </header>

    {{ form("users/create", "method":"post", "enctype":"multipart/form-data") }}
    {{ securityTag.csrf(csrf_params) }}
    <p>
        <label>{{ t._("name") }}</label>
        {{ text_field("name", "placeholder":t._("first")) }}
        {{ text_field("last-name", "placeholder":t._("lastname")) }}
    </p>
    <p>
        <label>{{ t._("email") }}</label>
        {{ text_field("email", "placeholder":t._("email")) }}
    </p>
    <p>
        <label>{{ t._("type") }}</label>
        {{ select('type', types, 'using': ['id', 'name'],
        'emptyText': 'Please, choose one type') }}
    </p>
    <p>
        <label>{{ t._("cohort") }}</label>
        {{ select('group-id', cohorts, 'using': ['groupId', 'stage'],
        'emptyText': 'Please, choose one type') }}
    </p>
    <p>
        <label>{{ t._("password") }}</label>
        {{ password_field("password", "placeholder":t._("password")) }}
    </p>
    <p>
        <label>{{ t._("Confirm Password") }}</label>
        {{ password_field("confirm-password", "placeholder":t._("Confirm Password")) }}
    </p>
    <p>
        <label>{{ t._("photo") }}</label>
        {{ file_field("photo", "placeholder":t._("photo")) }}
    </p>
    <p>
        {{ submit_button(t._("create"), "class":"btn")}}
    </p>
    </form>
</div>