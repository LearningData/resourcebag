<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("calendar") }}</h1>
        <h2>{{ t._("edit-title")}}</h2>
    </header>

    {{ form("calendar/update", "method":"post", "class":"form-inline") }}
        {{ partial("calendar/_form") }}
        <input type="hidden" name="event-id" value="{{ event.id }}">
    </form>
    <a href="/schoolbag/calendar/remove/{{ event.id }}" class="btn">{{ t._("delete") }}</a>
    <button class="btn btn-cancel btn-return">
        {{ t._("cancel")}}
    </button>
</div>
