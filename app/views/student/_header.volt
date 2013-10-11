<!--h1>Welcome</h1-->
<a class="schoolbag-brand" href="/">
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
    {{ link_to("student/edit/", "My Profile", 'class':"bt-myprofile") }}
    {{ link_to("session/logout", "Logout", 'class':"bt-logout") }}
    <!--{{ link_to("student/changePassword/", "Change Password") }}-->

    <form class="form-search" role="search">
        <input type="text" class="form-control" placeholder="Search">
        <button type="submit" class="btn-search">
            Search
        </button>
    </form>
</div>