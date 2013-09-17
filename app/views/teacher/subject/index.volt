{% include "teacher/_header.volt" %}

<h1>Subjects</h1>

<table>
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
            <td>{{ listClass.users.count() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>