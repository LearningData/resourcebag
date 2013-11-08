<div class="ld-calendar purple">
    <header>
        <h1>{{ t._("calendar") }}</h1>
    </header>
    {{ link_to(user.getController()~"/calendar/new","class":"btn mbottom-20", t._("New Event")) }}
    {{ securityTag.csrf(csrf_params) }}
    <div id="calendar"></div>
</div>
