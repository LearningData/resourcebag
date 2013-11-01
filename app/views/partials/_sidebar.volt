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
            {{ link_to(user.getController()~"/noticeboard", "School Notices") }}
            <span class="badge">14</span>
        </li>
        <li class="events">
            {{ link_to(user.getController()~"/calendar", "Calendar") }}
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            {{ link_to(user.getController()~"/timetable", "Timetable") }}
        </li>
        <li class="homework">
            {{ link_to(user.getController()~"/homework?filter=2", "Homework") }}
        </li>
        <li class="classes">
            {{ link_to(user.getController()~"/classes", "Classes") }}
        </li>
        <li class="ebooks">
            <a href="#">Ebooks</a>
        </li>
        <li class="resources">
            <a href="#">Resources</a>
        </li>
        <li class="policies">
            {{ link_to(user.getController()~"/policies", "School Policies") }}
        </li>
    </nav>
</div>
