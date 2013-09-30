<h2 class="h2-homework">Homework {{ homework.text }}</h2>

<section>
	<h4>Files uploaded:</h4>
	<table class="table">
		<thead>
			<th>File Name</th>
			<th>Description</th>
			<th></th>
		</thead>
		{% for file in homework.files %}
		<tr>
			<td>{{ file.originalName }}</td>
			<td>{{ file.description }}</td>
			<td>{{ link_to("homework/removeFile/"~file.id, "class":"btn-remove btn-icon", "Remove") }}</td>
		</tr>
		{% endfor %}
	</table>
</section>
<br>
<br>

{{ form("homework/uploadFile", "method":"post", "enctype":"multipart/form-data") }}
<p>
	<input type="file" name="file">
</p>
<p>
	<textarea name="description" placeholder="Description"></textarea>
</p>
<input type="hidden" name="homework-id" value="{{ homework.id }}">
<p>
	<input type="submit" class="btn btn-homework" value="save">
</p>
</form>