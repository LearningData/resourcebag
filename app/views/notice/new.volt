<div class="ld-notices cerulean">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("new-notice") }}</h2>
    </header>
    <h3>{{ t._("create-notice") }}</h3>
    {{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"form") }}
    {{ partial("notice/_form") }}
    </form>
</div>
