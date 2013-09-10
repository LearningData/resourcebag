<h1>Welcome {{ user.FirstName }}</h1>

<nav>
    <a href="#">Change Password</a> |
    {{ link_to("users/edit/"~user.userID, "Edit") }} |
    <a href="#">Change Crest</a> |
    <a href="#">Change Policies</a> |
    <a href="#">Change Map</a> |
    <a href="#">Moodle</a> |
    <a href="#">School's Website</a> |
    <a href="/schoolbag/session/logout">logout</a>
</nav>