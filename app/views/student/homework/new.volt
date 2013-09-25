<h2>New homework </h2>

{{ form("student/createHomework", "method":"post") }}
    <p>
        <label>Homework</label>
        <textarea rows="4" cols="300" name="description"></textarea>
    </p>
    <p>
        <label>Class</label>
        {{ select('classList-id', classes, 'using': ['id', 'name']) }}
    </p>
    <p>
        <label>Due Date</label>
        <input type="text" name="due-date" id="due-date">
    </p>
    <p><input type="submit"></p>
</form>