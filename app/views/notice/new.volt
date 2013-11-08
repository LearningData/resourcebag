<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices-title") }}</h1>
        <h2>{{ t._("new-notice") }}</h2>
    </header>
    {{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"form") }}
    {{ securityTag.csrf(csrf_params) }}
    <p class="col-md-6 ">
        <label>{{ t._("create-notice") }}</label>
        <span class="radio-box form-control"> <span>
                <input type="radio" name="type" value="T" class="ld-teachers-only" checked="checked">
                {{ t._("teachers-only") }}</label> <label>
                    <input type="radio" name="type" value="A" class="ld-include-students">
                    {{ t._("teachers-students") }}</label> </span>
    </p>
    <p class="col-md-6 ld-classes-tree">
        <label>{{ t._("restrict-to") }}</label>
        <input type="text" value="{{ t._('all-teachers') }}" id="class-id" name="classes" class="form-control ld-no-tree" disabled="disabled">
        </input>
    </p>
    <div class="clearfix"></div>
    <p class="col-md-12">
        <label>{{ t._("message") }}</label>
        {{ text_area("notice", "placeholder":t._("notice"), "class":"form-control") }}
    </p>
    <p class="col-md-6">
        {{ t._("notice date") }}
        {{ text_field("date", "placeholder":t._("date"), "id":"notice-note-date", "class":"form-control") }}
    </p>
    <p class="col-md-6">
        {{ t._("add a file") }}
        <input type="file" name="file">
    </p>
    <p class="col-md-6">
        <label>{{ t._("notice-category") }}</label>
        {{ select('category', categories, 'using': ['id', 'name'], "class":"form-control") }}
    </p>
    <div class="clearfix"></div>
    {{ submit_button(t._("save"), "class":"btn") }}
    <button class="btn btn-cancel btn-return" type="button">
        {{ t._("cancel") }}
    </button>
    </form>
</div>
