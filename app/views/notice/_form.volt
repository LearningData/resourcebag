{{ securityTag.csrf(csrf_params) }}
<p class="mtop-20"><label>{{ t._("notice-for") }}</label></p>
<span id="nts-frm-who">
    <p class="pull-left mright-10">
        <label>
            <input type="radio" name="type" value="A"
                class="ld-all-school" checked="checked"
                data-target="#nts-frm-who" data-required-key="one">
            {{ t._("all-school") }}
        </label>
    </p>
    <p class="pull-left mright-10">
        <label>
            <input type="radio" name="type" value="T"
                data-target="#nts-frm-who" data-required-key="one"
                {% if notice.userType == "T" %}
                    checked= "true"
                {% endif %}
                class="ld-teachers-only">
            {{ t._("teachers-only") }}
        </label>
    </p>
    <p class="pull-left">
        <label>
            <input type="radio" name="type" value="P"
                data-target="#nts-frm-who" data-required-key="one"
                {% if notice.userType == "P" %}
                    checked= "true"
                {% endif %}
                class="ld-include-students">
            {{ t._("teachers-students") }}
        </label>
    </p>
    <p class="validation-error">{{ t._("select-least-one") }}</p>
</span>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 ld-classes-tree mtop-20">
    <label>{{ t._("share-with") }}</label>
    <input type="text" value="{{ t._('all-teachers') }}" id="class-id" name="classes" class="form-control ld-no-tree-teachers col-md-6 hidden" disabled="disabled">
    <input type="text" value="{{ t._('all-school') }}" id="class-id" name="classes" class="form-control ld-no-tree-all col-md-6" disabled="disabled">
    </input>
</div>
<div id="nts-frm-msg" class="col-md-12">
    <label>{{ t._("message") }}</label>
    {{ text_area("notice", "placeholder":t._("notice"),
        "class":"form-control", "rows":"5",
        "data-required-key":"true", "data-target":"#nts-frm-msg") }}
        <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
</div>
<p id="hwk-nts-display-date" class="col-md-6">
    {{ t._("notice-date") }}
    {{ text_field("date", "placeholder":t._("date"), "id":"notice-note-date", "class":"form-control",
        "data-required-key":"date", "data-target":"#hwk-nts-display-date") }}
    <span class="validation-error">{{ t._("needs-date") }}</span>
</p>
<p class="col-md-6">
    {{ t._("add-file") }}
    <input type="file" name="file">
</p>
<p class="col-md-6">
    <label>{{ t._("notice-category") }}</label>
    {{ select('category', categories, 'using': ['id', 'name'], "class":"form-control") }}
</p>
<p class="col-md-6">
    {{ t._("expiry-date") }}
    {{ text_field("expiryDate", "placeholder":t._("expiry-date"),
        "id":"notice-note-date", "class":"form-control",
        "value": expiryDate) }}
</p>
</div>
<div class="clearfix"></div>
{{ submit_button(t._("save"), "class":"btn") }}
<button class="btn btn-cancel btn-return" type="button">
    {{ t._("cancel") }}
</button>
{{ hidden_field("notice-id") }}

