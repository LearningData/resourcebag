<h1 id="homework-header" class="homework-header">Homework</h2>
<h2 class="homework-subheader">{{ homework.textEditor }}</h2>

<section class="homework-view">
     <button id="add-homework-text" class="btn bg-hwk bg-hwk-hv mtop-20" data-homework-id="{{ homework.id }}">Add Text Input</button>
    <button id="upload-homework-file" class="btn bg-hwk bg-hwk-hv mtop-20" data-homework-id="{{ homework.id }}">Upload File</button>
    <button id="save-homework-text" class="btn bg-hwk bg-hwk-hv mtop-20" data-homework-id="{{ homework.id }}" style="display:none">Save Text</button>
    {{ form("homework/update", "id": "text-form", "method":"post", "enctype":"multipart/form-data") }}
    <div id="text-inputs">
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
    <table class="table table-homework">
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
    {% else %}
        <h6>No files uploaded.</h6>
    {% endif %}
    {{ link_to("student/homework/submit/"~homework.id, "class":"btn btn-hwk mtop-20", "Submit Homework") }}
    <button class="btn bg-hwk bg-hwk-hv mtop-20 bt-return">Back</button>
</section>
