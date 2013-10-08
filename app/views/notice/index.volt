<h1>School Notice Board</h1>
{% for notice in notices %}
    <p>{{ notice.text }}</p>
    {% for file in notice.files %}
        <p>{{ link_to("download/noticeboard/"~file.id, "Download") }}</p>
    {% endfor %}
    <hr>
{% endfor %}