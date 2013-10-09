<h1>My Classes</h1>
{% for classList in user.classes %}
    <p>{{ classList.subject.name }}</p>
{% endfor %}

<h1>Classes</h1>

{{ form("student/listClasses", "method":"get") }}
    <p>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
            'emptyText': 'Please, choose one subject')}}
    </p>
    <p>
        <input type="submit">
    </p>
</form>
<table>
    {% for classList in classes %}
        <tr>
            <td>
                {{ classList.getSubject().name }} {{ classList.extraRef }}
            </td>
            <td>
                {{ link_to("student/joinClass/"~classList.id, "Join Class") }}
            </td>
        </tr>
    {% endfor %}
</table>