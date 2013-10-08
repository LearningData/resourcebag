<h1>School Notice Board</h1>
{% for notice in notices %}
    <p><strong>Message: </strong>{{ notice.text }}</p>
    <p>
        <strong>Author: </strong>
        {{ notice.author.name }} {{ notice.author.lastName }}
    </p>
    {% for file in notice.files %}
        <p>{{ link_to("download/noticeboard/"~file.id, "Download") }}</p>
    {% endfor %}
    <hr>
{% endfor %}