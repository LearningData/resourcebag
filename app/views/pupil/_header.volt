<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("pupil/changePassword/", "Change Password") }} |
    {{ link_to("pupil/edit/", "Edit") }} |
    <a href="#">Join Classes</a> |
    <a href="#">List of Teachers</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>