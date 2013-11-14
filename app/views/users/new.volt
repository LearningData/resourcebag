<div class="orange">
    <header>
        <h1>{{ t._("create-user") }}</h1>
    </header>

    {{ form("users/create", "method":"post", "enctype":"multipart/form-data") }}
    {{ securityTag.csrf(csrf_params) }}
    <div class="col-sm-6">
        <label>{{ t._("teacher-title") }}</label>
        {{ select('title', titles, 'using': ['id', 'name'],
        'emptyText': 'Please, choose one type') }}
    </div>
    <label>{{ t._("name") }}</label>
    <div class="row">
        <div class="col-sm-6">
            {{ text_field("name", "placeholder":t._("first")) }}
        </div>
        <div class="col-sm-6">
            {{ text_field("last-name", "placeholder":t._("lastname")) }}
        </div>
    </div>
    <label>{{ t._("email") }}</label>
    <div class="row">
        <div class="col-sm-8">
            {{ text_field("email", "placeholder":t._("email")) }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>{{ t._("type") }}</label>
            {{ select('type', types, 'using': ['id', 'name'],
            'emptyText': 'Please, choose one type') }}
        </div>
        <div class="col-sm-6">
            <label>{{ t._("cohort") }}</label>
            {{ select('group-id', cohorts, 'using': ['groupId', 'stage'],
            'emptyText': 'Please, choose one type') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>{{ t._("password") }}</label>
            {{ password_field("password", "placeholder":t._("password")) }}
        </div>
        <div class="col-sm-6">
            <label>{{ t._("Confirm Password") }}</label>
            {{ password_field("confirm-password", "placeholder":t._("Confirm Password")) }}
        </div>
    </div>
    <label>{{ t._("photo") }}</label>
    {{ file_field("photo", "placeholder":t._("photo")) }}
    {{ submit_button(t._("create"), "class":"btn")}}
    </form>
</div>
