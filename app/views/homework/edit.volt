<div class="ld-homework orange">
    <h1 id="header" class="header">Homework</h2>
    <h2 class="subheader">{{ homework.title }}</h2>
    <h3 class="description">{{ homework.text }}</h3>

    <section class="homework-view">
         <button id="add-homework-text" class="btn mtop-20" data-homework-id="{{ homework.id }}">Add Text Input</button>
        <button id="upload-homework-file" class="btn mtop-20" data-homework-id="{{ homework.id }}">Upload File</button>
        <button id="save-homework-text" class="btn mtop-20" data-homework-id="{{ homework.id }}" style="display:none">Save Text</button>
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
        <h4>Files uploaded:</h4>
        <table class="table">
            <thead>
                <th>File Name</th>
                <th>Description</th>
                <th></th>
                <th></th>
            </thead>
            {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td><span data-name="{{ file.originalName }}" data-file-id="{{ file.id }}" class="btn-remove btn-icon icon-remove" title="Remove"></span></td>
            </tr>
            {% endfor %}
        </table>
        {{ link_to("student/homework/submit/"~homework.id, "class":"btn mtop-20", "Submit Homework") }}
        {% else %}
            <h6>No files uploaded.</h6>
            <button class="btn mtop-20 btn-inactive">Submit Homework</button>
        {% endif %}
        <button class="btn mtop-20 return">Back</button>
    </section>
</div>
