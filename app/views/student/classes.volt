<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes")  }}</h1>
    </header>
    {% for classList in user.classes %}
    <p class="col-xs-3">
        {{ link_to("student/showClass/"~classList.id,
        classList.subject.name) }}({{ classList.extraRef }})
    </p>
    {% endfor %}
    <div class="clearfix"></div>
    <button class="btn join-class">
        {{ t._("join-class") }}
    </button>

    {{ form("student/joinClass", "method":"post", "class":"join-class hidden") }}
    {{ securityTag.csrf(csrf_params) }}
    <p>
        {{ select('class-id', classes, 'using': ['id', 'name'],
        'emptyText': 'Please, choose one class')}}
    </p>
    <p>
        <input type="submit" class="btn" value={{ t._("join") }}>
        <button type="button" class="btn btn-cancel">
            {{ t._("cancel") }}
        </button>
    </p>
    </form>
</div>
