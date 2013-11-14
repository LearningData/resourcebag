<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("notice") }}</h2>
    </header>
    <div class="note {{ notice.category }} notice-page-show">
        <span class="date">
            {{ notice.getDate(t._("dateformat")) }}
        </span> |
        <span class="author">
            {{ t._(notice.author.title) }} {{ notice.author.lastName }}
        </span>
        <p class="message">
                    <span class="ld-notice-icon"></span>
                    <p class="text">{{ notice.text }}</p>
                </p>
        {% for file in notice.files %}
        <p>
            {{ link_to("download/noticeboard/"~file.id, "class":"icon-download") }}
        </p>

        {% endfor %}

    </div>
