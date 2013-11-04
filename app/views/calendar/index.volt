<div class="ld-calendar purple">
    <h1>Calendar</h1>
    {{ link_to(user.getController()~"/calendar/new","class":"btn mbottom-20", t._("New Event")) }}
    {{ securityTag.csrf(csrf_params) }}
    <div id="calendar"></div>
</div>
