<h1>{{ homework.text }} ({{ homework.student.name }})</h1>

<table class="table">
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
                <td>{{ link_to("homework/downloadFile/"~file.id, "Download") }}</td>
            </tr>
        {% endfor %}
    </tbody>
</table>
<form action="/schoolbag/homework/reviewed/{{ homework.id }}">
    <p>
        <input type="submit">
    </p>
</form>
