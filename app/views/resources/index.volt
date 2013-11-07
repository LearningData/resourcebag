<h1>{{ t._("resources") }}</h1>
{% if not user.isStudent() %}
    {{ link_to("resources/new", "New",
    "class":"btn bg-event bg-event-hv mbottom-20",
    "style":"background-color: #939598;") }}
{% endif %}
<h2>Files:</h2>
{% for key, classList in classes %}
    <h3>{{ classList["name"] }}</h3>

    {% for resource in classList["resources"] %}
        <p>{{ image("img/icons/icon-file-generic.png") }}
            {{ link_to("resources/download/"~resource.id, resource.fileName) }}
            {% for resourceTag in resource.properties %}
                / {{ resourceTag.type }}
            {% endfor %}
        </p>
    {% endfor %}
{% endfor %}