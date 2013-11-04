<div class="nav-collapse collapse">
    <form class="form-search" role="search">
        <input type="text" class="form-control" placeholder="Search">
        <button type="submit" class="btn-search icon-search"></button>
    </form>
    <nav class="nav navbar-nav">
        <li class="dashboard active">
            <a href="/schoolbag/dashboard">
                <span class="custom-icon-dash-top"></span>
                <span class="custom-icon-dash"></span>Dashboard
            </a>
        </li>
        <li class="homework">
            <a href="/schoolbag/{{ user.getController() }}/homework?filter=0">
                <span class="custom-icon-homework"></span>Homework
            </a>
        </li>
        <li class="messages">
            <!--span class="badge">21</span-->
            <a href="#"><span class="icon-envelope"></span> Messages</a>
        </li>
        <li class="notices">
            <a href="/schoolbag/{{ user.getController() }}/noticeboard">
                <span class="custom-icon-notices"></span>School Notices
            </a>
            <span class="badge">5</span>
        </li>
        <li class="events">
            <a href="/schoolbag/{{ user.getController() }}/calendar">
                <span class="custom-icon-events"></span>Events
            </a>
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            <a href="/schoolbag/{{ user.getController() }}/timetable">
                <span class="custom-icon-timetable"></span>Timetable
            </a>
        </li>
        <li class="classes">
            <a href="/schoolbag/{{ user.getController() }}/classes">
                <span class="icon-group"></span>Classes
            </a>
        </li>
        <li class="ebooks">
            <a href="#"><span class="custom-icon-ebooks"></span>Ebooks</a>
        </li>
        <li class="resources">
            <a href="#"> <span class="icon-wrench"></span> Resources</a>
        </li>
        <li class="policies">
            <a href="/schoolbag/{{ user.getController() }}/policies">
                <span class="icon-lock"></span>School Policies
            </a>
        </li>
    </nav>
</div>