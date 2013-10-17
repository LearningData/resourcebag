<!--h1>Welcome</h1-->
<a class="schoolbag-brand" href="http://demo.learningdata.net/schoolbag">
    {{ image("img/logo.png", "alt":"Schoolbag", "width":"153", "heigth":"46") }}
</a>
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

    <form class="form-search" role="search">
        <input type="text" class="form-control" placeholder="Search">
        <button type="submit" class="btn-search">
            Search
        </button>
    </form>
</div>
