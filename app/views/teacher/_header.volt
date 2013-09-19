<h1>Welcome {{ user.name }} {{ user.lastName }}</h1>

<ul class="breadcrumb">
    {{ link_to("teacher/changePassword/", "Change Password") }} |
    {{ link_to("teacher/edit/", "Edit") }} |
    {{ link_to("teacher/newClass/", "Create Class") }} |
    {{ link_to("teacher/listClasses/", "Edit Class") }} |
    {{ link_to("teacher/listTeachers/", "List of Teachers") }} |
    {{ link_to("teacher/timetable", "Timetable") }} |
    {{ link_to("teacher/subjects", "Subjects") }} |
    {{ link_to("session/logout", "Logout") }}
</ul>