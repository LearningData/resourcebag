<div class="ld-notices blue">
    <h1 class="header">New Notice</h1>
    {{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"form") }}
    {{ securityTag.csrf(csrf_params) }}
    <p class="col-md-6 ">
        <label>{{ t._("create notice for") }}</label>
        <span class="radio-box form-control">
            <label><input type="radio" name="type" value="T" class="ld-teachers-only" checked="checked">{{ t._("teachers only") }}</label>
            <label><input type="radio" name="type" value="A" class="ld-include-students">{{ t._("teachers and students") }}</label>
        </span>
    </p>
    <p class="col-md-6 ld-classes-tree">
        <label>{{ t._("restrict to") }}</label>
        <input type="text" value="{{ t._('all teachers') }}" id="class-id" name="classes" class="form-control ld-no-tree" disabled="disabled"></input>
    </p>
    <div class="clearfix"></div>
    <p class="col-md-12">
        <label>{{ t._("message") }}</label>
        {{ text_area("notice", "placeholder":"Notice", "class":"form-control") }}
    </p>
    <p class="col-md-6">
        {{ t._("notice date") }}
        {{ text_field("date", "placeholder":"Date", "id":"notice-note-date", "class":"form-control") }}
    </p>
    <p class="col-md-6">
        {{ t._("add a file") }}
        <input type="file" name="file">
    </p>
    <p class="col-md-6">
        <label>{{ t._("notice category") }}</label>
        {{ select('category', categories, 'using': ['id', 'name'], "class":"form-control") }}
    </p>
    <div class="clearfix"></div>
    {{ submit_button("Save", "class":"btn") }}
    <button class="btn btn-cancel btn-return" type="button">Cancel</button>
    </form>
</div>
