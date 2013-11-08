<div class="blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("notice") }}</h2>
    </header>
    <div class="notice-space notice-page-show">
        <span class="date">{{ notice.getDate() }}</span> | <span class="author">{{ notice.author.name }} {{ notice.author.lastName }}</span>
        <p>
            {{ notice.text }}
        </p>
        {% for file in notice.files %}
        <p>
            {{ link_to("download/noticeboard/"~file.id, "Download") }}
        </p>

        {% endfor %}

    </div>
