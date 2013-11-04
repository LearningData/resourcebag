<div class="purple">
    <h1>Calendar</h1>
    {{ link_to(user.getController()~"/calendar/new","class":"btn bg-event bg-event-hv mbottom-20","New Event") }}
    {{ securityTag.csrf(csrf_params) }}
    <div id="calendar"></div>
</div>