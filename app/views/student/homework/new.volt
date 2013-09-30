<h2 class="h2-homework">Set new homework</h2>

{{ form("student/createHomework", "method":"post") }}
<p>
	<textarea name="description" placeholder="Homework"></textarea>
</p>
<p>
	<label>Class</label>
	<select name="classList-id" id="classList-id" class="customSelect" onchange="return getEnableDays(this);">
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
<p>
	<input class="btn btn-homework" type="submit" value="save">
</p>
</form>