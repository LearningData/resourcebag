<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("calendar") }}</h1>
        <h2>{{ t._("new-event")}}</h2>
    </header>

    {{ form("calendar/create", "method":"post", "class":"form-inline") }}
        {{ partial("calendar/_form") }}
    </form>
    <button type="button" class="btn btn-cancel btn-return">
        {{ t._("cancel")}}
    </button>
</div>
