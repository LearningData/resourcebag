<div class="nav-collapse collapse">
    <form class="form-search" role="search">
        <input type="text" class="form-control" placeholder="Search">
        <button type="submit" class="btn-search icon-search"></button>
    </form>
    <nav class="nav navbar-nav">
        <li class="dashboard active">
            <a href="/schoolbag/dashboard"> <span class="custom-icon-dash-top"></span> <span class="custom-icon-dash"></span>{{ t._("dashboard") }} </a>
        </li>
        <li class="homework">
            <a href="/schoolbag/{{ user.getController() }}/homework"> <span class="custom-icon-homework"></span>{{ t._("homework") }} </a>
        </li>
        <li class="messages">
            <!--span class="badge">21</span-->
            <a href="#"> <span class="icon-envelope"></span> {{ t._("messages") }} </a>
        </li>
        <li class="notices">
            <a href="/schoolbag/{{ user.getController() }}/noticeboard"> <span class="custom-icon-notices"></span>{{ t._("notices") }} </a>
            <span class="badge">5</span>
        </li>
        <li class="events">
            <a href="/schoolbag/{{ user.getController() }}/calendar"> <span class="custom-icon-events"></span>{{ t._("events") }} </a>
            <span class="badge">7</span>
        </li>
        <li class="timetable">
            <a href="/schoolbag/{{ user.getController() }}/timetable"> <span class="custom-icon-timetable"></span>{{ t._("timetable") }} </a>
        </li>
        <li class="classes">
            <a href="/schoolbag/{{ user.getController() }}/classes"> <span class="icon-group"></span>{{ t._("classes") }} </a>
        </li>
        <li class="ebooks">
            <a href="#"><span class="custom-icon-ebooks"></span> {{ t._("ebooks") }} </a>
        </li>
        <li class="resources">
            <a href="/schoolbag/resources"> <span class="icon-folder-open"></span> {{ t._("resources") }} </a>
        </li>
        <li class="policies">
            <a href="/schoolbag/{{ user.getController() }}/policies"> <span class="icon-lock"></span>{{ t._("policies") }} </a>
        </li>
        <li class="school-logo">
            {{ image("img/school-logo.png", "width":"117", "heigth":"138") }}
        </li>
    </nav>
</div>