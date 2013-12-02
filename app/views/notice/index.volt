<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
    </header>

    {% if not user.isStudent() %}
    <p>
        {{ link_to(user.getController()~"/noticeboard/new", t._("new"), "class":"btn") }}

        {% for myNotice in myNotices %}
            <p>{{ myNotice.text }}</p>
        {% endfor %}
    </p>
    {% endif %}
    <div class="notice-page">
        {% for notice in notices %}
        <div class="notice-space">
            <div class="note {{ notice.category }}">
                <span class="date">{{ notice.getDate(t._("dateformat")) }}
                </span> | <span class="author">{{ t._(notice.author.title) }}
                {{ notice.author.lastName }}</span>
                <p class="message">
                    <span class="ld-notice-icon"></span>
                    <span class="text">{{ notice.text }}</span>
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
