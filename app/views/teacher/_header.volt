<h1>Welcome {{ user.name }} {{ user.lastName }}</h1>

<nav>
    {{ link_to("teacher/changePassword/", "Change Password") }} |
    {{ link_to("teacher/edit/", "Edit") }} |
    {{ link_to("teacher/newClass/", "Create Class") }} |
    {{ link_to("teacher/listClasses/", "Edit Class") }} |
    {{ link_to("teacher/listTeachers/", "List of Teachers") }} |
    <a href="#">Select Friends</a> |
    <a href="#">Roll Call</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>

{{ content() }}