{% include "student/_header.volt" %}

<h1>Teachers</h1>

{% for teacher in teachers %}
    <p>{{ teacher.name }} {{ teacher.lastName }}</p>
{% endfor %}