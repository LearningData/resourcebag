{{ securityTag.csrf(csrf_params) }}
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("title-label")}}</label>
    {{ text_field("title", "placeholder": t._("title-label"),
        "class":"form-control", "value": event.title ) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("location")}}</label>
    {{ text_field("location", "placeholder":t._("location"),
        "class":"form-control", "value": event.location) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("url")}}</label>
    {{ text_field("link", "placeholder":t._("please-enter-url"),
        "class":"form-control", "value": event.url) }}
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("contact")}}</label>
    {{ text_field("contact", "placeholder":t._("contact"),
        "class":"form-control", "value": event.contact) }}
</p>
<div class="clearfix"></div>
<p class="col-sm-12 col-md-12">
    <label for="title">{{ t._("description")}}</label>
    {{ text_area("description", "placeholder":t._("description"), "class":"form-control") }}
</p>
<div class="clearfix"></div>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("start-date")}}</label>
    <input type="text" id="start-date" class="form-control" placeholder="{{ t._("start-date")}}" >
    <input type="hidden" id="hidden-start-date" name="start">
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("end-date")}}</label>
    <input type="text" id="end-date" placeholder="{{ t._("end-date")}}" class="form-control">
    <input type="hidden" id="hidden-end-date" name="end">
</p>
<div class="clearfix"></div>
<P class="col-sm-12">  {{ check_field("allDay", "id":"all-day") }} {{ t._("all-day")}}</P>
<span class="all-day-block">
<p class="col-sm-6 col-md-6">
    <label for="time">{{ t._("start-time")}}</label>
    <input type="text" id="start-time" class="form-control" placeholder="{{ t._("start-time")}}" >
    <input type="hidden" name="start-time">
</p>
<p class="col-sm-6 col-md-6">
    <label for="title">{{ t._("end-time")}}</label>
    <input type="text" id="end-time" placeholder="{{ t._("end-time")}}" class="form-control">
</p>
</span>
<input type="hidden" name="user-id" value="{{ event.userId }}">
{{ submit_button(t._("save"),"class":"btn") }}
