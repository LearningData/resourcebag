<h1>Welcome {{ user.name }} {{ user.lastName }}</h1>

<nav>
    {{ link_to("teacher/changePassword/"~user.id, "Change Password") }} |
    {{ link_to("teacher/edit/"~user.id, "Edit") }} |
    <a href="#">Edit subjects</a> |
    {{ link_to("teacher/newClass/", "Create Class") }} |
    <a href="#">Edit Class</a> |
    <a href="#">Delete Class</a> |
    {{ link_to("teacher/listTeachers/", "List of Teachers") }} |
    <a href="#">Select Friends</a> |
    <a href="#">Roll Call</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>