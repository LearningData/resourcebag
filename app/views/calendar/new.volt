<h1>New Event</h1>

{{ form("calendar/create", "method":"post") }}
    <p>
        <label>Title</label>
        {{ text_field("title") }}
    </p>
    <p>
        <label>Link</label>
        {{ text_field("link") }}
    </p>
    <p>
        <label>Location</label>
        {{ text_field("location") }}
    </p>
    <p>
        <label>Contact</label>
        {{ text_field("contact") }}
    </p>
    <p>
        <label>Description</label>
        {{ text_area("description") }}
    </p>
    <p>
<<<<<<< HEAD
        {{ select_static("allDay", options)}}
    </p>
    <p>
=======
>>>>>>> fixed
        <label>Start Date</label>
        <input type="date" name="start">
    </p>
    <p>
        <label>End Date</label>
        <input type="date" name="end">
    </p>
    <p>
        {{ submit_button("Save") }}
    </p>
</form>