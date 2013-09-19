<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("student/changePassword/", "Change Password") }} |
    {{ link_to("student/edit/", "Edit") }} |
    {{ link_to("student/listClasses/", "Join Classes") }} |
    {{ link_to("student/subjects/", "Subjects") }} |
    {{ link_to("student/listTeachers/", "Teachers") }} |
    {{ link_to("student/timetable", "Timetable") }} |
    {{ link_to("session/logout", "Logout") }}
</nav>