<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
        <h2>{{ t._("edit-homework") }}</h2>
    </header>
    {{ form("homework/updateHomework", "method":"post",
        "enctype":"multipart/form-data", "class":"form") }}
        {{ text_field("title", "placeholder": t._("homework-title"),
            "value": homework.title) }}
        {{ text_field("due-date", "placeholder": t._("due-date"),
            "value": homework.dueDate) }}
        {{ text_area("description", "placeholder":t._("description"),
            "id":"homework-description", "class":"form-control",
            "value": homework.text) }}
        <!--
        {{ select('class-id', classes, 'using': ['id', 'name'],
            "class":"form-control") }}
        -->

        {{ hidden_field("homework-id", "value": homework.id) }}
        {{ submit_button(t._("save"), "class":"btn") }}
    </form>
</div>