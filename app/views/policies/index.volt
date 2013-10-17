<h1>School Policies</h1>
{% if user.isSchool() %}
    {{ link_to("policies/new", "New")}}
{% endif %}
{% for file in files %}
    <p>{{ file["extension"] }} - {{ link_to("policies/download/"~file["name"], file["name"])}}</p>
{% endfor %}