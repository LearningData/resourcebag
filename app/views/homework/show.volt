<h1 class="homework-header">Homework</h1>
<h2 class="homework-subheader">{{ homework.textEditor }}</h2>

<section class="homework-view">
    <hr class="div">
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
                <td>{{ link_to("download/homework/"~file.id, "class":"btn-icon btn-download icon-download") }}</td>
            </tr>
        {% endfor %}
    </table>
    <button class="btn bg-hwk bg-hwk-hv mtop-20 bt-return">Back</button>
</section>
