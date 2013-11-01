<div class="blue">
    <h1>School Notice Board</h1>

    {% if not user.isStudent() %}
    {{ link_to(user.getController()~"/noticeboard/new", "New") }}
    {% for notice in notices %}
    <p>
        <strong>Message: </strong>{{ notice.text }}
    </p>
    <p>
        <strong>Author: </strong>
        {{ notice.author.name }} {{ notice.author.lastName }}
    </p>
    {% for file in notice.files %}
    <p>
        {{ link_to("download/noticeboard/"~file.id, "Download") }}
    </p>
    {% endfor %}
    <p>
        {% if user.id == notice.author.id %}
        {{ link_to(user.getController()~"/noticeboard/edit/"~notice.id, "Edit") }}
        {% endif %}
    </p>
    <p>
        {{ link_to(user.getController()~"/noticeboard/show/"~notice.id, "Show")}}
    </p>
    <p>
        {{ notice.getDate() }}
    </p>
    {% endfor %}
    {% else %}
    <div class="student notice-page">
        <ul>
            <li id = "ntebrd1" class="note note-lvl1 col-md-8"></li>
            <li id = "ntebrd2" class="note note-lvl2 col-md-4">

            </li>
            <li id = "ntebrd3" class="note note-lvl3 col-md-4">

            </li>
            <li id = "ntebrd4" class="note note-lvl3 col-md-4">

            </li>
            <li id = "ntebrd5" class="note note-lvl3 col-md-4">

            </li>
        </ul>
    </div>
    {% endif %}
</div>