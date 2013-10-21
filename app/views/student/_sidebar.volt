<div class="nav-collapse collapse">
    <nav class="nav navbar-nav">
        <li class="dashboard active">
            {{ link_to("dashboard", "Dashboard") }}
        </li>
        <li class="homework">
            <a href="/schoolbag/student/homework?filter=0"><span class="custon-icon-homework"></span>Homework</a>
        </li>
        <li class="messages">
            <!--span class="badge">21</span-->
            <a href="#"><span class="icon-envelope"></span> Messages</a>
        </li>
        <li class="notices">
            <a href="/schoolbag/student/noticeboard"><span class="custon-icon-notices"></span>School Notices</a>
            <span class="badge">5</span>
        </li>
        <li class="events">
            <a href="/schoolbag/student/calendar"><span class="custon-icon-events"></span>Events</a>
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            <a href="/schoolbag/student/timetable"><span class="custon-icon-timetable"></span>Timetable</a>
        </li>
        <li class="classes">
            <a href="/schoolbag/student/listClasses"><span class="icon-group"></span>Classes</a>
        </li>
        <li class="ebooks">
            <a href="#">Ebooks</a>
        </li>
        <!--<li class="journal">
            {{ link_to("student/subjects/", "Journal") }}
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
