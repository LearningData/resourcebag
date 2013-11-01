<div class="nav-collapse collapse">
    <nav class="nav navbar-nav">
        <li class="dashboard active">
            {{ link_to("dashboard", "Dashboard") }}
        </li>
        <li class="messages">
            <span class="badge">21</span>
            <a href="#">Messages</a>
        </li>
        <li class="notices">
            {{ link_to(user.getController()~"/noticeboard", t._("notices")) }}
            <span class="badge">14</span>
        </li>
        <li class="events">
            {{ link_to(user.getController()~"/calendar", t._("calendar")) }}
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            {{ link_to(user.getController()~"/timetable", t._("timetable")) }}
        </li>
        <li class="homework">
            {{ link_to(user.getController()~"/homework?filter=2", t._("homework")) }}
        </li>
        <li class="classes">
            {{ link_to(user.getController()~"/classes", t._("classes")) }}
        </li>
        <li class="ebooks">
            <a href="#">{{ t._("ebooks") }}</a>
        </li>
        <li class="resources">
            <a href="#">{{ t._("resources") }}</a>
        </li>
        <li class="policies">
            {{ link_to(user.getController()~"/policies", t._("policies")) }}
        </li>
    </nav>
</div>
