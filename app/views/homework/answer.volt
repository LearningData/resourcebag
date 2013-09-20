<h2>Homework {{ homework.text }}</h2>

<section>
    <h4>Files uploaded:</h4>
    {% for file in homework.files %}
        <p>{{ file.originalName }}</p>
    {% endfor %}
</section>
<br><br>

<form action="/schoolbag/homework/uploadAnswer"
            method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="hidden" name="homework-id" value="{{ homework.id }}">
    <input type="submit">
</form>