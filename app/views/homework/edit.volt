<h2 class="h2-homework">Homework {{ homework.text }}</h2>

<section>
    <div id="upload-homework-file" class="bt-upload" data-homework-id="{{ homework.id }}">Upload File</div>
    <h4>Files uploaded:</h4>
    <table class="table table-homework">
        <thead>
            <th>File Name</th>
            <th>Description</th>
            <th></th>
        </thead>
        {% for file in homework.files %}
        <tr>
            <td>{{ file.originalName }}</td>
            <td>{{ file.description }}</td>
            <td><span data-name="{{ file.originalName }}" data-file-id="{{ file.id }}" class="btn-remove btn-icon">"Remove"</span></td>
        </tr>
        {% endfor %}
    </table>
</section>

