<div class="ld-notices blue">
    <header>
        <h1>{{ t._("notices") }}</h1>
        <h2>{{ t._("new-notice") }}</h2>
    </header>
    {{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"form") }}
    {{ securityTag.csrf(csrf_params) }}

    <h3>{{ t._("create-notice") }}</h3>
    <p class="mtop-20"><label>{{ t._("notice-for") }}</label></p>
    <p class="pull-left mright-10">
        <input type="radio" name="type" value="T" class="ld-teachers-only" checked="checked">
        <label>{{ t._("teachers-only") }}</label>
    </p>
    <p class="pull-left">
        <input type="radio" name="type" value="A" class="ld-include-students">
        <label> {{ t._("teachers-students") }}</label>
    </p>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 ld-classes-tree mtop-20">
        <label>{{ t._("restrict-to") }}</label>
        <input type="text" value="{{ t._('all-teachers') }}" id="class-id" name="classes" class="form-control ld-no-tree col-md-6" disabled="disabled">
        </input>
    </div>
    <div class="col-md-12">
        <label>{{ t._("message") }}</label>
        {{ text_area("notice", "placeholder":t._("notice"), "class":"form-control", "rows":"5") }}
    </div>
    <p class="col-md-6">
        {{ t._("notice-date") }}
        {{ text_field("date", "placeholder":t._("date"), "id":"notice-note-date", "class":"form-control") }}
    </p>
    <p class="col-md-6">
        {{ t._("add-file") }}
        <input type="file" name="file">
    </p>
    <p class="col-md-6">
        <label>{{ t._("notice-category") }}</label>
        {{ select('category', categories, 'using': ['id', 'name'], "class":"form-control") }}
    </p>
    </div>
    <div class="clearfix"></div>
    {{ submit_button(t._("save"), "class":"btn") }}
    <button class="btn btn-cancel btn-return" type="button">
        {{ t._("cancel") }}
    </button>
    </form>
</div>
