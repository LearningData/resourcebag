<h1>{{ homework.text }} ({{ homework.student.name }})</h1>

<table class="table table-homework">
    <thead>
        <th>File Name</th>
        <th>Descritpion</th>
        <th>Download</th>
    </thead>
    <tbody>
        {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td>{{ link_to("download/homework/"~file.id,"class":"btn-icon btn-download icon-download", "Download") }}</td>
            </tr>
        {% endfor %}
    </tbody>
</table>
{{ form("homework/reviewed/"~homework.id, "method":"post") }}
    <p>
        <input type="submit">
    </p>
</form>
