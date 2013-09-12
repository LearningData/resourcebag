{% include "teacher/_header.volt" %}
{{ content() }}

{% for teacher in teachers %}
    <p>{{ teacher.name }} {{teacher.lastName}}</p>
{% endfor %}