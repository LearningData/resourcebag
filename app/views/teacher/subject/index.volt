{% include "teacher/_header.volt" %}

<h1>Subjects</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Class</th>
            <th>Year</th>
            <th>Students</th>
        </tr>
    </thead>
    <tbody>
    {% for listClass in classes %}
        <tr>
            <td>{{listClass.subject.name }} ({{ listClass.extraRef }}) </td>
            <td>{{ listClass.year }}</td>
            {% if listClass.users.count() %}
                <td><a href="#">{{ listClass.users.count() }}</a></td>
            {% else %}
                <td>{{ listClass.users.count() }}</td>
            {% endif %}
        </tr>
    {% endfor %}
    </tbody>
</table>