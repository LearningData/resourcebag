<h1>Welcome {{ user.name }}</h1>

<nav>
    {{ link_to("admin/newSchool", "New School") }}
    {{ link_to("admin", "View Schools") }}
    {{ link_to("admin/listConfigs", "View Configurations") }}
    {{ link_to("admin/newConfig", "New Configuration") }}
    {{ link_to("session/logout", "Logout") }}
</nav>