<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("student/changePassword/", "Change Password") }} |
    {{ link_to("student/edit/", "Edit") }} |
    {{ link_to("student/listClasses/", "Join Classes") }} |
    {{ link_to("student/myClasses/", "My Classes") }} |
    {{ link_to("student/listTeachers/", "Teachers") }} |
    {{ link_to("student/timetable", "Timetable") }} |
    <a href="#">Change Crest</a> |
    <a href="#">Change Policies</a> |
    <a href="#">Change Map</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>

{{ content() }}