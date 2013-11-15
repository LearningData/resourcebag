{{ securityTag.csrf(csrf_params) }}
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("title-label")}}</label>
    {{ text_field("title", "placeholder": t._("title-label"),
        "class":"form-control", "value": event.title ) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("link")}}</label>
    {{ text_field("link", "placeholder":t._("address"),
        "class":"form-control", "value": event.url) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("location")}}</label>
    {{ text_field("location", "placeholder":t._("location"),
        "class":"form-control", "value": event.location) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("contact")}}</label>
    {{ text_field("contact", "placeholder":t._("contact"),
        "class":"form-control", "value": event.contact) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("description")}}</label>
    {{ text_area("description", "placeholder":t._("description"),
        "class":"form-control", "value": event.description) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="allDay">{{ t._("all-day")}}</label>
    {{ select_static("allDay", options,
        "class":"form-control", "value": event.allDay)}}
</p>
<div class="clearfix"></div>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("startDate")}}</label>
    <input type="text" id="start-date" name="start"
        class="form-control" placeholder="{{ t._("startDate")}}" value="{{ event.start }}">
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("endDate")}}</label>
    <input type="text" id="end-date" name="end"
        placeholder="{{ t._("endDate")}}" class="form-control" value="{{ event.end }}">
</p>
<input type="hidden" name="user-id" value="{{ event.userId }}">
{{ submit_button(t._("save"),"class":"btn") }}