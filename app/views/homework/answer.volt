<h2>{{ homework.text }}</h2>

<form action="/schoolbag/homework/uploadAnswer"
            method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="hidden" name="homework-id" value="{{ homework.id }}">
    <input type="submit">
</form>