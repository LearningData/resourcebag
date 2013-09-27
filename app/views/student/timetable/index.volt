<h1>Timetable</h1>
<div class="nav-timetable">
	<a title="Prev" class="nav-timetable-btn-prev"><span>Prev</span></a>
	<a title="Next" class="nav-timetable-btn-next"><span>Next</span></a>
	<div class="nav-timetable-title"><h2>Current Week</h2></div>
</div>

<table class="table table-timetable">
	<thead>
		<tr>
			{% for day in period %}
			<th>{{ day.format("l d") }}</th>
			{% endfor %}
		</tr>
	</thead>
	<tbody>
		<tr>
			{% for daySlots in slots %}
			<td> {% for slot in daySlots %}
			<p>
				{{ slot }}
			</p> {% endfor %} </td>
			{% endfor %}
		</tr>
	</tbody>
</table>