<div class="event purple">
    <h1>New Event</h1>
    {{ form("calendar/create", "method":"post", "class":"form-inline") }}
    {{ securityTag.csrf(csrf_params) }}
    <p class="col-sm-6 col-md-6">
        {{ text_field("title", "placeholder":"Title", "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        {{ text_field("link", "placeholder":"Link", "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        {{ text_field("location", "placeholder":"Location", "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        {{ text_field("contact", "placeholder":"Contact", "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        {{ text_area("description", "placeholder":"Description", "class":"form-control") }}
    </p>
    <p class="col-sm-6 col-md-6">
        {{ select_static("allDay", options, "class":"form-control")}}
    </p>
    <div class="clearfix"></div>
    <p class="col-sm-6 col-md-6">
        <input type="text" id="start-date" name="start" placeholder="Start Date" class="form-control">
    </p>
    <p class="col-sm-6 col-md-6">
        <input type="text" id="end-date" name="end" placeholder="End Date" class="form-control">
    </p>
    {{ submit_button("Save","class":"btn") }}
    </form>
    <button class="btn btn-cancel btn-return">
        Cancel
    </button>
</div>
