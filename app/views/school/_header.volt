<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("school/changePassword/", "Change Password") }} |
    {{ link_to("school/edit/", "Edit") }} |
    {{ link_to("school/timetable/", "Timetable") }} |
    {{ link_to("school/noticeboard/", "Notice Board") }} |
    <a href="/schoolbag/session/logout">logout</a>
</nav>