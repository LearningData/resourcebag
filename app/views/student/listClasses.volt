{% include "student/_header.volt" %}

{% for classList in classes %}
    <p>{{ classList.getSubject().name }} {{ classList.teacherId }}</p>
{% endfor %}