<h2 class="h2-homework">Homework {{ homework.text }}</h2>

<section>
    <div id="upload-homework-file" class="bt-upload" data-homework-id="{{ homework.id }}">Upload Homework File</div>
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
