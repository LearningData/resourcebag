<h2>Homework {{ homework.text }}</h2>

<section>
    <h4>Files uploaded:</h4>
    <table class="table">
        <thead>
            <th>File Name</th>
            <th>Description</th>
            <th></th>
        </thead>
        {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td>{{ link_to("download/homework/"~file.id,"Download") }}</td>
            </tr>
        {% endfor %}
    </table>
</section>