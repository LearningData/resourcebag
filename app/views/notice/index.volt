<div class="blue">
    <h1>School Notice Board</h1>
    {% if not user.isStudent() %}
    <p>{{ link_to(user.getController()~"/noticeboard/new", "New", "class":"btn") }}</p>
    {% endif %}
    {% for notice in notices %}
    <div class="notice-page">
        <div class="note">
            <span class="date">{{ notice.getDate() }}</span> | <span class="author">{{ notice.author.name }} {{ notice.author.lastName }}</span>
            <p class="message">
                {{ notice.text }}
            </p>

            {% for file in notice.files %}
            <p>
                {{ link_to("download/noticeboard/"~file.id, "Download") }}
            </p>
            {% endfor %}

            <div class="btn-group btn-group-xs">
                {% if user.id == notice.author.id %}
                {{ link_to(user.getController()~"/noticeboard/edit/"~notice.id, "Edit", "class":"btn") }}
                {% endif %}
                {{ link_to(user.getController()~"/noticeboard/show/"~notice.id, "Read More", "class":"btn btn-group-sm")}}
            </div>
        </div>
    </div>
    {% endfor %}

</div>