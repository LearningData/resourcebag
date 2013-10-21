<h1>New Notice</h1>

{{ form("notice/create", "method":"post", "enctype":"multipart/form-data", "class":"frm-notice") }}
<p class="col-md-6">
    {{ text_area("notice", "placeholder":"Notice", "class":"form-control") }}
</p>
<p class="col-md-6">
    {{ text_field("date", "placeholder":"Date", "id":"notice-note-date") }}
</p>
<div class="clearfix"></div>
<span class="col-md-6">
        <div class="radio-box">
            <div><label><input type="radio" name="type" value="A"> Teachers/Students</label></div>
            <div><label><input type="radio" name="type" value="T"> Teachers</label></div>
            <div><label><input type="radio" name="type" value="P"> Students</label></div>
        </div>
</span>
<p class="col-md-6">
    {{ select('class-id', classes, 'using': ['id', 'name'], "class":"form-control") }}
</p>
<p class="col-md-6">
    <input type="file" name="file">
</p>
<div class="clearfix"></div>
<p>
    {{ submit_button("Save", "class":"btn bg-notice bg-notice-hv") }}
</p>
</form>
