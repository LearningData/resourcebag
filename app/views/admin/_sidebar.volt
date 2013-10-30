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
            {{ link_to("teacher/noticeboard", "School Notices") }}
            <span class="badge">14</span>
        </li>
        <li class="events">
            {{ link_to("teacher/calendar", "Calendar") }}
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            {{ link_to("teacher/timetable", "Timetable") }}
        </li>
        <li class="homework">
            {{ link_to("teacher/homework?filter=2", "Homework") }}
        </li>
        <li class="classes">
            {{ link_to("teacher/subjects/", "Classes") }}
        </li>
        <li class="ebooks">
            <a href="#">Ebooks</a>
        </li>
        <!--<li class="journal">
            {{ link_to("#", "Journal") }}
        </li>
        <li class="copies">
            <a href="#">Copies</a>
        </li>-->
        <li class="resources">
            <a href="#">Resources</a>
        </li>
        <li class="policies">
            {{ link_to("policies", "School Policies") }}
        </li>
    </nav>
</div>
