<div class="nav-collapse collapse">
    <nav class="nav navbar-nav">
        <li class="dashboard active">
            {{ link_to("dashboard", "Dashboard") }}
        </li>
        <li class="homework">
            {{ link_to("student/homework?filter=0", "Homework") }}
        </li>
        <li class="messages">
            <span class="badge">21</span>
            <a href="#">Messages</a>
        </li>
        <li class="notices">
            {{ link_to("student/noticeboard", "School Notices") }}
            <span class="badge">14</span>
        </li>
        <li class="calendar">
            {{ link_to("student/calendar", "Calendar") }}
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            {{ link_to("student/timetable", "Timetable") }}
        </li>
        <li class="classes">
            {{ link_to("student/listClasses/", "Classes") }}
        </li>
        <li class="ebooks">
            <a href="#">Ebooks</a>
        </li>
        <li class="journal">
            {{ link_to("student/subjects/", "Journal") }}
        </li>
        <li class="copies">
            <a href="#">Copies</a>
        </li>
        <li class="resources">
            <a href="#">Resources</a>
        </li>
        <li class="policies">
            <a href="#">School Policies</a>
        </li>
    </nav>
</div>