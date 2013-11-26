<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("calendar") }}</h1>
    </header>
    <div class="col-sm-12">
        <a href="/schoolbag/{{ user.getController() }}/calendar/new"><span class="custom-icon-new-homework"></span>{{ t._("new-event") }}</a>
        <hr />
    </div>
    
    <div id="calendar" class="col-sm-9"></div>
    <div id="agenda" class="col-sm-3 fc-header fc-header-title">
        <h2>Agenda</h2>
    </div>
</div>
