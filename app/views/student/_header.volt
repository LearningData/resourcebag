<a class="schoolbag-brand" href="#"> {{ image("img/logo.png", "alt":"Schoolbag", "width":"153", "heigth":"46") }} </a>
<div class="user-profile">
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
    <a href="/schoolbag/student/edit/" class="btn-profile"><span class="icon-user"></span> My Profile</a>
    <a href="/schoolbag/session/logout/" class="btn-logout"><span class="icon-off"></span> Logout</a>
    <button type="button" class="icon-caret-down"></button>
    <button type="button" class="navbar-toggle icon-reorder" data-toggle="collapse" data-target=".nav-collapse">
        
    </button>
</div>
