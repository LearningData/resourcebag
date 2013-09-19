<h1>My classes</h1>

{% for classList in user.classList %}
    <p>{{ classList.subject.name }} - {{ classList.extraRef }}</p>
{% endfor %}