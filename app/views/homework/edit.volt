<div class="ld-homework orange">
    <h1 id="header" class="header">{{ t._("homework") }}</h2>
    <h2 class="subheader"><span class="label">{{ t._("title-label") }}</span>{{ homework.title }}</h2>
    <h3 class="description"><span class="label">{{ t._("description")}}</span>{{ homework.text }}</h3>
    <section class="homework-view">
         <button id="add-homework-text" class="btn mtop-20" data-homework-id="{{ homework.id }}">{{ t._("add-text-input") }}</button>
        <button id="upload-homework-file" class="btn mtop-20" data-homework-id="{{ homework.id }}">{{ t._("upload-file") }}</button>
        <button id="save-homework-text" class="btn mtop-20" data-homework-id="{{ homework.id }}" style="display:none">{{ t._("save-text") }}</button>
        {{ form("homework/update", "id": "text-form", "method":"post", "enctype":"multipart/form-data") }}
        <div id="text-inputs">
            <div class="homework-subheader">{{ homework.textEditor }}</div>
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
            <button class="btn mtop-20 btn-inactive">{{ t._("submit-homework") }}</button>
        {% endif %}
        <button class="btn mtop-20 btn-cancel return">{{ t._("homework-exit") }}</button>
    </section>
</div>
