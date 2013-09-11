<h1>Welcome {{ user.name }} {{ user.lastName }}</h1>

<nav>
    {{ link_to("teacher/changePassword/"~user.id, "Change Password") }} |
    {{ link_to("teacher/edit/"~user.id, "Edit") }} |
    <a href="#">Change Crest</a> |
    <a href="#">Change Policies</a> |
    <a href="#">Change Map</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>