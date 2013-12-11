<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
        <h2>{{ t._("edit-homework") }}</h2>
    </header>
    {{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"form") }}
    {{ text_field("title", "placeholder": t._("homework-title")) }}
    {{ text_field("dueDate", "placeholder": t._("due-date")) }}
    {{ text_area("description", "placeholder":t._("description"),
    "id":"homework-description", "class":"form-control",
    "value": expiryDate) }}
    </form>
</div>