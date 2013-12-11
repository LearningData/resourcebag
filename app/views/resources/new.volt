<div class="resources blue">
    <header>
        <h1>{{ t._("resources") }}</h1>
        <h2>{{ t._("resource-upload") }}</h2>
    </header>
    {{ form("resources/upload", "method":"post", "enctype":"multipart/form-data") }}
    <p class="col-md-12">
        <label>{{ t._("description") }}</label>
        {{ text_area("description") }}
    </p>
    <div class="clearfix"></div>
    <p class="col-md-6">
        <label>{{ t._("subject") }}</label>
        {{ select("subject-id", classes, 'using': ['id', 'value']) }}
    </p>
    <p class="col-md-6">
        {{ t._("file") }}
        <input type="file" name="file">
    </p>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <label>{{ t._("group") }} {{ link_to("resources/newTag", "New") }}</label>
        <div>
            {% for property in properties %}
            <p class="col-xs-2">
                {{ check_field("tags[]", "value": property.id) }} {{ property.name }}
            </p>
            {% endfor %}
        </div>
    </div>
    <div class="clearfix"></div>
    <p class="col-md-6">
        {{ submit_button(t._("upload"), "class":"btn") }}
        <button type="button" class="btn btn-cancel btn-return">
            {{ t._("cancel") }}
        </button>
    </p>
    </form>
</div>
