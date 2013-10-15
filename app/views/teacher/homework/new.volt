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
        <label>Class: {{ classList.subject.name }}</label>
    </p>
    <p>
        <label>Due Date</label>
        <input type="text" name="due-date" id="due-date">
    </p>
    <div id="due-times"></div>
    <input type="hidden" name="week-days" id="week-days" value="{{ weekDays }}">
    <input type="hidden" name="class-id" id="class-id"
        value="{{ classList.id }}">
    <h3>Assign students</h3>
    <div id="students">
        {% for user in classList.users %}
            <p>{{ check_field("students[]", "value": user.id) }}
                {{ user.name }} {{ user.lastName }}</p>
        {% endfor %}
    </div>
    <p><input class="btn btn-homework" type="submit" value="save"></p>

</form>