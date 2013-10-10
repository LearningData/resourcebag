<h1>School Notice Board</h1>
{% if not user.isStudent() %}
    {{ link_to(user.getController()~"/noticeboard/new", "New") }}
{% endif %}
{% for notice in notices %}
    <p><strong>Message: </strong>{{ notice.text }}</p>
    <p>
        <strong>Author: </strong>
        {{ notice.author.name }} {{ notice.author.lastName }}
    </p>
    {% for file in notice.files %}
        <p>{{ link_to("download/noticeboard/"~file.id, "Download") }}</p>
    {% endfor %}
    <p>
        {% if user.id == notice.author.id %}
            {{ link_to(user.getController()~"/noticeboard/edit/"~notice.id, "Edit") }}
        {% endif %}
    </p>
    <p>
        {{ notice.getDate() }}
    </p>
    <hr>
{% endfor %}