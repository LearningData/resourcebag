<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("event") }}</h1>
    </header>
    <div class="col-sm-12 ld-new-buttons">
        <a href="/schoolbag/{{ user.getController() }}/calendar/new"><span class="custom-icon-new-homework"></span>{{ t._("new-event") }}</a>
        {{ securityTag.csrf(csrf_params) }}
        <hr />
    </div>
    <div id="calendar" class="col-xs-12 col-sm-9"></div>
    <div id="agenda" class="col-xs-12 col-sm-3 fc-header fc-header-title agenda">
        <h2>{{ t._("diary") }}</h2>
    </div>
</div>

<div id="createNewEventPopover" class="hidden">
    {{ form("calendar/create", "method":"post", "class":"popover-form") }}
    {{ securityTag.csrf(csrf_params) }}
    <button class="close" type="button">
        &times;
    </button>
    <p id="frm-evt-title">
    <label>{{ t._("what") }}</label>
    <input type="text" name="title" id="title" class="form-control" placeholder="{{ t._("title-label") }}" data-required-key="true" data-target="#frm-evt-title">
    <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
    </p>
    <p>
        <span class="icon-calendar"></span><span id="event-date"></span>
    </p>

    <input class="btn btn-sm" type="submit" value="{{ t._("create-event") }}">
    <button type="button" class="btn btn-sm btn-cancel details">
        {{ t._("add-more-details") }}
    </button>
    <input type="hidden" name="allDay" value="1">
    <input type="hidden" name="start" id="start" value="">
    <input type="hidden" name="end" id="end" value="">

    </form>

</div>
