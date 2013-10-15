<h1>Class {{ classList.subject.name }}</h1>

{% for student in classList.users %}
    <p>{{ student.name }} {{ student.lastName }}</p>
{% endfor %}