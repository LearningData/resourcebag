<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("school/changePassword", "Change Password") }} |
    {{ link_to("school/edit", "Edit") }} |
    {{ link_to("school/timetable", "Timetable") }} |
    {{ link_to("school/noticeboard", "Notice Board") }} |
    {{ link_to("school/users/new", "Create New User") }} |
    {{ link_to("school/listUsers", "List Users") }} |
    {{ link_to("cohort", "List Cohorts") }} |
    {{ link_to("session/logout", "Logout") }}
</nav>