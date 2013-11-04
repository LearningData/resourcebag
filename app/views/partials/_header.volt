<header>
    <a class="schoolbag-brand" href="/schoolbag/dashboard">
        {{ image("img/logo.png", "alt":"Schoolbag", "width":"153", "heigth":"46") }}
    </a>
    <div class="user-profile">
        <button type="button" class="navbar-toggle icon-reorder"
            data-toggle="collapse" data-target=".nav-collapse"></button>
        <div class="tb-user">
            {% if user.photo %}
            {{ image("download/photo", "alt":"", "width":"67", "height":"62") }}
            {% else %}
            {{ image("#") }}
            {% endif %}

        </div>

        <span class="name-school"> {{ user.name }}
            <br />
            <strong>{{ user.school.name }}</strong>
                <button type="button"
                    class="icon-caret-down btn-profile-actions"></button>
            </span>

        <div class="user-profile-actions">
            <a href="/schoolbag/{{ user.getController() }}/edit/"
                    class="btn-profile">
                <span class="icon-user"></span> Profile
            </a>
            <a href="/schoolbag/{{ user.getController() }}/changePassword/" class="btn-logout">
                <span class="icon-lock"></span> Change Password
            </a>
            <a href="/schoolbag/session/logout/" class="btn-logout">
                <span class="icon-off"></span> Logout
            </a>
        </div>
    </div>
</header>
