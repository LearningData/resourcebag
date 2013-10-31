<header>
    <a class="schoolbag-brand" href="#"> {{ image("img/logo.png", "alt":"Schoolbag", "width":"153", "heigth":"46") }} </a>
    <div class="user-profile">
        <button type="button" class="navbar-toggle icon-reorder" data-toggle="collapse" data-target=".nav-collapse"></button>
        <div class="tb-user">
            {% if user.photo %}
            {{ image("download/photo", "alt":"", "width":"67", "height":"62") }}
            {% else %}
            {{ image("#") }}
            {% endif %}

        </div>
        <p class="name-school">
            {{ user.name }}
            <br />
            <strong>{{ user.school.name }}</strong>
        </p>

        <div class="user-profile-actions">
            <a href="/schoolbag/student/edit/" class="btn-profile"><span class="icon-user"></span> My Profile</a>
            <a href="/schoolbag/session/logout/" class="btn-logout"><span class="icon-off"></span> Logout</a>
        </div>
        <button type="button" class="icon-caret-down"></button>
        <nav>
            {{ link_to("admin/newSchool", "New School") }}
            {{ link_to("admin", "View Schools") }}
            {{ link_to("admin/listConfigs", "View Configurations") }}
            {{ link_to("admin/newConfig", "New Configuration") }}
            {{ link_to("session/logout", "Logout") }}
        </nav>
    </div>
</header>