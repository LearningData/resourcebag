{{ securityTag.csrf(csrf_params) }}

<div id="evt-frm-title" class="col-sm-6 col-md-6">
    <label for="title">{{ t._("title-label")}}*</label>
    {{ text_field("title", "placeholder": t._("title-label"), "class":"form-control", "value": event.title, "data-target":"#evt-frm-title", "data-required-key":"true" ) }}
    <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
</div>
<div class="col-sm-6 col-md-6">
    <label for="title">{{ t._("location")}}</label>
    {{ text_field("location", "placeholder":t._("location"), "class":"form-control", "value": event.location) }}
</div>
<div class="col-sm-6 col-md-6">
    <label for="title">{{ t._("url")}}</label>
    {{ text_field("link", "placeholder":t._("please-enter-url"), "class":"form-control", "value": event.url) }}
</div>
<div class="col-sm-6 col-md-6">
    <label for="title">{{ t._("contact")}}</label>
    {{ text_field("contact", "placeholder":t._("contact"), "class":"form-control", "value": event.contact) }}
</div>
<div class="clearfix"></div>
<div class="col-sm-12 col-md-12">
    <label for="title">{{ t._("description")}}</label>
    {{ text_area("description", "placeholder":t._("description"), "class":"form-control", "value": event.description) }}
</div>
<div class="col-sm-6 col-md-6" id="evt-frm-start">
    <label for="title">{{ t._("start-date")}}*</label>
    <input type="text" id="start-date" class="form-control" placeholder="{{ t._('start-date')}}" data-target="#evt-frm-start" data-required-key="date" >
    <input type="hidden" id="hidden-start-date" name="start" value="{{ event.start }}">
    <span class="validation-error">{{ t._("needs-date") }}</span>
</div>
<p class="col-sm-6 col-md-6" id="evt-frm-end">
    <label for="title">{{ t._("end-date")}}</label>
    <input type="text" id="end-date" placeholder="{{ t._("end-date")}}" class="form-control" data-target="#evt-frm-end" data-required-key="date" data-date-after="#start-date">
    <input type="hidden" id="hidden-end-date" name="end" value="{{ event.end }}">
    <span class="validation-error">{{ t._("invalid-date") }}</span>
</p>
<div class="clearfix"></div>
<div class="col-sm-12">
    <input type="checkbox" name="allDay" value="1" id="all-day" {% if event.allDay == 1 %} checked="checked" {% endif %}>
    {{ t._("all-day")}}
</div>
<div class="all-day-block {% if event.allDay == 1 %} hidden {% endif %}">
    <div class="clearfix mtop-20"></div>
    <div id="evt-frm-start-time " class="col-sm-6 col-md-6">
        <label for="time">{{ t._("start-time")}}</label>
        <input type="text" id="start-time" class="form-control"
        value="{{ startTime }}" placeholder="{{ t._("start-time")}}" data-required-key="time" data-target="#evt-frm-start-time" >
        <input type="hidden" name="start-time">
        <span class="validation-error">{{ t._("invalid-time") }}</span>
    </div>
    <div id="evt-frm-end-time" class="col-sm-6 col-md-6">
        <label for="title">{{ t._("end-time")}}</label>
        <input type="text" id="end-time" placeholder="{{ t._("end-time")}}" class="form-control" value="{{ endTime }}" data-required-key="time" data-target="#evt-frm-end-time" >
        <span class="validation-error">{{ t._("invalid-time") }}</span>
    </div>
</div>
<div class="clearfix mbottom-20"></div>
<input type="hidden" name="user-id" value="{{ event.userId }}">
{{ submit_button(t._("save"),"class":"btn") }}
