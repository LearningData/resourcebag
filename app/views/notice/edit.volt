<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("edit-notice") }}</h2>
    </header>
    <h3>{{ t._("edit-notice") }}</h3>
    {{ form("notice/update", "method":"post", "class":"inline")}}
    {{ partial("notice/_form") }}
    </form>
</div>
