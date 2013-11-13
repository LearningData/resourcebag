<div class="grey">
    <header>
        <h1>{{ t._("school-policies") }}</h1>
        <h2>{{ t._("upload-file") }}</h2>
    </header>

    {{ form("policies/upload", "method":"post", "enctype":"multipart/form-data") }}
    <input type="file" name="file">
    {{ submit_button("Upload", "class":"btn") }}
    </form>
</div>