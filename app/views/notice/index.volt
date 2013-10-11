<h1>School Notice Board</h1>
{% if not user.isStudent() %}
    {{ link_to(user.getController()~"/noticeboard/new", "New") }}
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
{% else %}
    <div class="gridster student notice-page">
    <ul>
    {% for notice in notices %}
        <li class="notice" data-row="1" data-col="1" data-sizex="1" data-sizey="1">
            <h3>{{ notice.getDate() }}</h3>
            <p class="message">{{ notice.text }}</p>
            <span class="author">Created by {{ notice.author.name }} {{ notice.author.lastName }}</span>
<!--            {% for file in notice.files %}
                <span>{{ link_to("download/noticeboard/"~file.id, "Download") }}</span>
            {% endfor %}
-->
        </li>
    {% endfor %}
    </ul>
    </div>
{% endif %}

