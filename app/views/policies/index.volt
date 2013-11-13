<div class="grey">
    <header>
        <h1>{{ t._("school-policies") }}</h1>
    </header>
    {% if not user.isStudent() %}
    {{ link_to("policies/new", "New", "class":"btn bg-event bg-event-hv mbottom-20") }}
    {% endif %}
    <h3>Files:</h3>
    {% for file in files %}
    <p>
        {{ image("img/icons/icon-file-"~file["extension"]~".png") }}
        {{ link_to("policies/download/"~file["name"], file["name"])}}
    </p>
    {% endfor %}
</div>