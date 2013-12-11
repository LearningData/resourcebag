<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("event") }}</h1>
        <h2>{{ t._("edit-title")}}</h2>
    </header>

    {{ form("calendar/update", "method":"post", "class":"form-inline") }}
    {{ partial("calendar/_form") }}
        <input type="hidden" name="event-id" value="{{ event.id }}">
        <button type="button" class="btn btn-cancel btn-return">
            {{ t._("cancel")}}
        </button>
        <button type="button" class="btn-delete" data-title="{{ event.title }}" data-id="{{ event.id }}">
            <span class="icon-trash"></span>{{ t._("delete") }}
        </button>
    </form>

</div>
