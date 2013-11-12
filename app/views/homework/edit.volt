<div class="ld-homework orange">
    <header>
        <h1 id="header">{{ t._("homework") }}</h1>
        <h2>{{ t._("edit") }}</h1>
    </header>
    <div class="row">
        <span class="col-md-3">
            <h3><span class="label">{{ t._("homework") }}:</span></br>
            {{ homework.title }}</h3>
        </span>
        <span class="col-md-3">
            <h3><span class="label">{{ t._("teacher") }}:</span><br/>
            {{ t._(homework.classList.user.name) }} {{ homework.classList.user.lastName}}</h3>
        </span>
        <span class="col-md-3">
            <h3><span class="label">{{ t._("class") }}:</span><br/>
            {{ homework.classList.subject.name }} ({{ homework.classList.extraRef }})</h3>
        </span>
        <span class="col-md-3">
            <h3><span class="label">{{ t._("due-date") }}:</span><br/>
            {{ homework.dueDate }}</h3>
        </span>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <h3><span class="label">{{ t._("description") }}:</span><br/>
            {{ homework.text }}</h3>
        </div>
    </div>
    <section class="homework-view">
        <button id="add-homework-text" class="btn mtop-20 btn-sm" data-homework-id="{{ homework.id }}">
            {{ t._("add-text-input") }}
        </button>
        <button id="upload-homework-file" class="btn mtop-20 btn-sm" data-homework-id="{{ homework.id }}">
            {{ t._("upload-file") }}
        </button>
        <button id="save-homework-text" class="btn mtop-20 btn-sm" data-homework-id="{{ homework.id }}" style="display:none">
            {{ t._("save-text") }}
        </button>
        {{ form("homework/update", "id": "text-form", "method":"post", "enctype":"multipart/form-data") }}
        <div id="text-inputs">
            <div class="homework-subheader">
                {{ homework.textEditor }}
            </div>
            <div id="homework-text-editor" spellcheck="true">
                <input type="hidden" name="homework-id" value="{{ homework.id }}">
                <textarea id="summernote"
                    name="content-homework" rows="18" style="display: none;">
                    {{ homework.textEditor }}
                </textarea>
            </div>
        </div>
        </form>
        <hr class="div">
        {% if homework.files.count() != 0 %}
        <h4>{{ t._("files-uploaded") }}</h4>
        <table class="table">
            <thead>
                <th>{{ t._("file-name") }}</th>
                <th>{{ t._("description") }}</th>
                <th></th>
                <th></th>
            </thead>
            {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td><span data-name="{{ file.originalName }}" data-file-id="{{ file.id }}" class="btn-remove btn-icon icon-remove" title="Remove"></span></td>
                <td></td>
            </tr>
            {% endfor %}
        </table>
        {{ link_to("student/homework/submit/"~homework.id, "class":"btn mtop-20", t._("submit-homework")) }}
        {% else %}
        <h6>{{ t._("no-files-uploaded") }}.</h6>
        <button class="btn mtop-20 btn-inactive">
            {{ t._("submit-homework") }}
        </button>
        {% endif %}
        <button class="btn mtop-20 btn-cancel return">
            {{ t._("homework-exit") }}
        </button>
    </section>
</div>
