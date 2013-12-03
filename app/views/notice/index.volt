<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
    </header>

    {% if not user.isStudent() %}
    <p>
        {{ link_to(user.getController()~"/noticeboard/new", t._("new"), "class":"btn") }}
        {% if myNotices|length > 0 %}
            <button class="btn view-user-notices">{{ t._("my-notices") }}</button>
        {% endif %}
        <table class="user-notices hidden">
            <thead>
            <tr>
                <th>{{ t._("category") }}</th>
                <th colspan=6>{{ t._("notice")}}</th>
                <th>{{ t._("audience") }}</th>
                <th colspan=2>{{ t._("display-date") }}</th>
                <th colspan=2>{{ t._("expiry-date") }}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
        {% for myNotice in myNotices %}
            <tr class={% if date('Y-m-d h:i:s') < myNotice.date %}
                    "pending" 
                {% elseif date('Y-m-d h:i:s') > myNotice.expiryDate %}
                    "expired"
                {% else %}
                    "active"
                   {% endif %}>
                <td class="note {{ myNotice.category }}"><span class="ld-notice-icon"></span></td>
                <td colspan=6 class="text">{{ myNotice.text }}</td>
                <td>{{ myNotice.userType }}</td>
                <td colspan=2>{{ myNotice.getDate(t._("dateformat")) }}
                <td colspan=2>{{ myNotice.expiryDate }}</td>
                <td>{{ link_to(user.getController()~"/noticeboard/edit/"~myNotice.id, "class":"btn-icon icon-pencil") }}</td>
                <td>{{ link_to(user.getController()~"/noticeboard/edit/"~myNotice.id, "class":"btn-icon icon-remove") }}</td>
            </tr>
        {% endfor %}
        </tbody>
        </table>
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
