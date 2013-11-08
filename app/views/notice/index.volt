<div class="blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
    </header>

    {% if not user.isStudent() %}
    <p>
        {{ link_to(user.getController()~"/noticeboard/new", "New", "class":"btn") }}
    </p>
    {% endif %}
    <div class="notice-page">
        {% for notice in notices %}
        <div class="notice-space">
            <div class="note">
                <span class="date">{{ notice.getDate() }}</span> | <span class="author">{{ notice.author.name }} {{ notice.author.lastName }}</span>
                <p class="message">
                    {{ notice.text }}
                </p>
                <div class="btn-group btn-group-xs">
                    {% if user.id == notice.author.id %}
                    {{ link_to(user.getController()~"/noticeboard/edit/"~notice.id, "class":"btn-icon icon-pencil") }}
                    {% endif %}

                    {% for file in notice.files %}
                    {{ link_to("download/noticeboard/"~file.id, "class":"btn-icon icon-download") }}
                    {% endfor %}

                </div>
                {{ link_to(user.getController()~"/noticeboard/show/"~notice.id, "Read More")}}
            </div>
        </div>
        {% endfor %}
    </div>
</div>