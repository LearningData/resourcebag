<h2>New homework </h2>

{{ form("teacher/createHomework", "method":"post") }}
    <p>
        <label>Title</label>
        <input type="text" name="title">
    </p>
    <p>
        <label>Homework</label>
        <textarea rows="4" cols="300" name="description"></textarea>
    </p>
    <p>
        <label>Class</label>
        <select name="classList-id" id="classList-id"
            class="customSelect" onchange="return populeStudentsAndDays(this);">
            {% for classId, name in classes %}
            <option value="{{ classId }}"> {{ name }} </option>
            {% endfor %}
        </select>
    </p>
    <p>
        <label>Due Date</label>
        <input type="text" name="due-date" id="due-date">
    </p>
    <div id="due-times"></div>
    <input type="hidden" name="week-days" id="week-days">
    <input type="hidden" name="class-id" id="class-id">
    <h3>Assign students</h3>
    <div id="students"></div>
    <p><input type="submit"></p>

</form>