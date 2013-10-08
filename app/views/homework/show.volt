<h1 class="homework-header">Homework</h1>
<h2 class="homework-subheader">{{ homework.text }}</h2>

<section class="homework-view">
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
    <button class="bt-return">Back To Homework</button>
</section>
