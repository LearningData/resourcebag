<h2>Homework {{ homework.text }}</h2>

<section>
    <h4>Files uploaded:</h4>
    <table class="table">
        <thead>
            <th>File Name</th>
            <th>Description</th>
        </thead>
        {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
            </tr>
        {% endfor %}
    </table>
</section>
<br><br>

<form action="/schoolbag/homework/uploadFile"
            method="post" enctype="multipart/form-data">
    <p>
        <label>File</label>
        <input type="file" name="file">
    </p>
    <p>
        <label>Description</label>
        <textarea name="description"></textarea>
    </p>
    <input type="hidden" name="homework-id" value="{{ homework.id }}">
    <p>
        <input type="submit">
    </p>
</form>