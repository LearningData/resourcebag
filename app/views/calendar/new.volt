<div class="event purple">
    <h1>{{ t._("newTitle")}}</h1>
    {{ form("calendar/create", "method":"post", "class":"form-inline") }}
    {{ securityTag.csrf(csrf_params) }}
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("title-label")}}</label>
        {{ text_field("title", "placeholder": t._("title-label"), "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("link")}}</label>
        {{ text_field("link", "placeholder":t._("address"), "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("location")}}</label>
        {{ text_field("location", "placeholder":t._("location"), "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("contact")}}</label>
        {{ text_field("contact", "placeholder":t._("contact"), "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("description")}}</label>
        {{ text_area("description", "placeholder":t._("description"), "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("all-day")}}</label>
        {{ select_static("allDay", options, "class":"form-control")}}
    </p>
    <div class="clearfix"></div>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("startDate")}}</label>
        <input type="text" id="start-date" name="start" class="form-control" placeholder="{{ t._("startDate")}}" >
    </p>
    <p class="col-sm-6 col-md-6">
        <label for="title">{{ t._("endDate")}}</label>
        <input type="text" id="end-date" name="end" placeholder="{{ t._("endDate")}}" class="form-control">
    </p>
    {{ submit_button(t._("save"),"class":"btn") }}
    </form>
    <button class="btn btn-cancel btn-return">
        {{ t._("cancel")}}
    </button>
</div>
