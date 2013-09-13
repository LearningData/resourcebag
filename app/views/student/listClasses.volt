{% include "student/_header.volt" %}
<h1>Classes</h1>

<form action="/schoolbag/student/listClasses" method="get">
    <p>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
            'emptyText': 'Please, choose one subject')}}
    </p>
    <p>
        <input type="submit">
    </p>
</form>
<table onload="selectOption();">
    {% for classList in classes %}
        <tr>
            <td>
                {{ classList.getSubject().name }} {{ classList.extraRef }}
            </td>
            <td>
                <a href="#">Join</a>
            </td>
        </tr>
    {% endfor %}
</table>