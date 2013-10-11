<h2>New Notice</h2>

{{ form("notice/create", "method":"post", "enctype":"multipart/form-data") }}
<p>
    <label for="notice">Notice</label>
    <textarea name="notice"></textarea>
</p>
<p>
    <input type="date" name="date">
</p>
<p>
    <input type="radio" name="type" value="A"> Teachers/Students
</p>
<p>
    <input type="radio" name="type" value="T"> Teachers
</p>
<p>
    <input type="radio" name="type" value="P"> Students
</p>
<p>
    {{ select('class-id', classes, 'using': ['id', 'name']) }}
</p>
<p>
    <input type="file" name="file">
</p>
<p>
    <input type="submit">
</p>
</form>