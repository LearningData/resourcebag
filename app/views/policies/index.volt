<h1>School Policies</h1>
{% if user.isSchool() %}
    {{ link_to("policies/new", "New")}}
{% endif %}
{% for file in files %}

    <p>{{ image("img/icons/icon-file-"~file["extension"]~".png") }}
        {{ link_to("policies/download/"~file["name"], file["name"])}}
    </p>
{% endfor %}