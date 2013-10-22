<h1>My Classes</h1>
{% for classList in user.classes %}
    <p>{{ classList.subject.name }}</p>
{% endfor %}

<h1>Classes</h1>

{{ form("student/joinClass", "method":"post") }}
    <p>
        {{ select('class-id', classes, 'using': ['id', 'name'],
            'emptyText': 'Please, choose one class')}}
    </p>
    <p>
        <input type="submit">
    </p>
</form>