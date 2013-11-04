<div class="ld-homework orange">
    <h1 class="header">Homework</h1>
    <h2 class="subheader">{{ homework.title }}</h2>
    <h3 class="description">{{ homework.text }}</h3>

    <section class="homework-view">
        <hr class="div">
        <div class="subheader">{{ homework.textEditor }}</div>
        <h4>Files uploaded:</h4>
        <table class="table">
            <thead>
                <th>File Name</th>
                <th>Description</th>
                <th></th>
            </thead>
            {% for file in homework.files %}
                <tr>
                    <td>{{ link_to("download/homework/"~file.id, file.originalName) }}</td>
                    <td>{{ file.description }}</td>
                    <td>{{ link_to("download/homework/"~file.id, "class":"btn-icon btn-download icon-download") }}</td>
                </tr>
            {% endfor %}
        </table>
        <button class="btn mtop-20 return">Back</button>
    </section>
</div>
