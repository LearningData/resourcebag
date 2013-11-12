<div class="ld-homework orange">
    <header>
        <h1 id="header">{{ t._("homework") }}</h1>
        <h2>{{ t._("show") }}</h1>
    </header>
    <div class="row">
        <span class="col-md-4">
            <h3><span class="label">{{ t._("homework") }}:</span></br>
            {{ homework.title }}</h3>
        </span>
        <span class="col-md-4">
            <h3><span class="label">{{ t._("teacher") }}:</span><br/>
            {{ t._(homework.classList.user.name) }} {{ homework.classList.user.lastName}}</h3>
        </span>
        <span class="col-md-4">
            <h3><span class="label">{{ t._("class") }}:</span><br/>
            {{ homework.classList.subject.name }} ({{ homework.classList.extraRef }})</h3>
        </span>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <h3><span class="label">{{ t._("description") }}:</span><br/>
            {{ homework.text }}</h3>
        </div>
    </div>
    <hr/>
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
        <h6>{{ t._("no-files-uploaded") }}.</h6>
        {% endif %}
        <button class="btn mtop-20 return">
            Back
        </button>
    </section>
</div>

