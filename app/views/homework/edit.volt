<div class="ld-homework orange">
    <header>
        <h1 id="header">{{ t._("homework") }}</h1>
        <h2>{{ t._("editing") }} - {{ homework.title }}</h2>
    </header>

    <section>
        <h3>{{ homework.classList.subject.name }} <span class="h4"> {{ t._("with") }}</span> {{ t._(homework.classList.user.title) }} {{ homework.classList.user.lastName}} {{ homework.getDueDate(t._("dateformat")) }}</h3>
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
    <section class="homework-text">
       {{ form("homework/update", "id": "text-form", "method":"post", "enctype":"multipart/form-data") }}
        <h3>{{ t._("text") }}</h3>
        <div id="homework-text-editor" spellcheck="true" placeholder="{{ t._('enter-homework-text') }}">{{ homework.textEditor }}</div>
        <textarea  name="content-homework" style="display:none;"></textarea>
        <button id="save-homework-text" class="btn mtop-20 btn-sm" data-homework-id="{{ homework.id }}">
            {{ t._("save-text") }}
        </button>
        <input type="hidden" name="homework-id" value="{{ homework.id }}">
        </form>
    </section>

    <section>
        {% if homework.files.count() != 0 %}
        <h3>{{ t._("files-uploaded") }}</h3>
        <button id="upload-homework-file" class="btn mtop-20 btn-sm mbottom-20" data-homework-id="{{ homework.id }}">
            {{ t._("upload-file") }}
        </button>
        <table class="table">
            <thead>
                <th>{{ t._("file-name") }}</th>
                <th>{{ t._("description") }}</th>
                <th>{{ t._("action") }}</th>
            </thead>
            {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td><span data-name="{{ file.originalName }}" data-file-id="{{ file.id }}" class="btn-remove btn-icon icon-remove" title="Remove"></span></td>
            </tr>
            {% endfor %}
        </table>

        {% else %}
        <h3>{{ t._("no-files") }}</h3>
        <button id="upload-homework-file" class="btn mtop-20 btn-sm" data-homework-id="{{ homework.id }}">
            {{ t._("upload-file") }}
        </button>

        {% endif %}

    </section>
    {% if homework.files.count() == 0 and homework.textEditor|striptags|trim|length == 0 %}
    <button class="btn mtop-20 btn-inactive">
        {{ t._("submit-homework") }}
    </button>
    {% else %}
    {{ link_to("student/homework/submit/"~homework.id, "class":"btn mtop-20", t._("submit-homework")) }}
    {% endif %}
    <button class="btn mtop-20 btn-cancel return">
        {{ t._("homework-exit") }}
    </button>
</div>
