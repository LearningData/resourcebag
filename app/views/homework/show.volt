<div class="ld-homework orange">
    <header>
        <h1 id="header">{{ t._("homework") }}</h1>
        <h2>{{ t._("showing") }} - {{ homework.title }}</h1>
    </header>
    <section>
        <div class="col-sm-12">
            <h3>{{ homework.info.classList.subject.name }} <span class="h6">{{ t._("with") }}</span> {{ homework.info.classList.user.title }} {{ homework.info.classList.user.lastName}}</h3>
        </div>
        <div class="col-sm-12">
            <h4></h4>
        </div>
        <div class="col-sm-12">
            <h6>{{ t._("description") }}</h6>
            <p>
                <strong>{{ homework.title }}</strong><br />
                {{ homework.text }}
            </p>
        </div>
    </section>
    <section class="homework-view">
        <div id="text-inputs">
            <div class="homework-subheader">
                {{ homework.textEditor }}
            </div>
        </div>
        <h4>{{ t._("files-uploaded") }}</h4>
        {% if homework.files.count() != 0 %}
        <table class="table">
            <thead>
                <th>{{ t._("file-name") }}</th>
                <th>{{ t._("description") }}</th>
                <th>{{ t._("action") }}</th>
            </thead>
            {% for file in homework.files %}
            <tr>
                <td>{{ link_to("download/homework/"~file.id, file.originalName) }}</td>
                <td>{{ file.description }}</td>
                <td><span data-name="{{ file.originalName }}" data-file-id="{{ file.id }}" class="btn-remove btn-icon icon-remove" title="Remove"></span></td>
            </tr>
            {% endfor %}
        </table>
        {% else %}
        <h6>{{ t._("no-files") }}</h6>
        {% endif %}

    </section>
</div>

