<h1>School Policies</h1>
{% if not user.isStudent() %}
    {{ link_to("policies/new", "New",
    "class":"btn bg-event bg-event-hv mbottom-20",
    "style":"background-color: #939598;") }}
{% endif %}
<h2>Files:</h2>
{% for file in files %}
    <p>{{ image("img/icons/icon-file-"~file["extension"]~".png") }}
        {{ link_to("policies/download/"~file["name"], file["name"])}}
    </p>
{% endfor %}