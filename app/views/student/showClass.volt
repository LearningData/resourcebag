<h1>{{ classList.subject.name }} homeworks</h1>
{% for homework in homeworks %}
    {{ homework.id }}
{% endfor %}