<h1>School Notice Board</h1>
{% for notice in notices %}
    <p>{{ notice.text }}</p>
{% endfor %}