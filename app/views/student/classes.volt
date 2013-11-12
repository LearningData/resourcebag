<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes")  }}</h1>
    </header>
    <section class="ld-subsection first">
        <h2>{{ t._("my-classes") }}</h2>
    {% for classList in user.classes %}
    <p class="col-xs-3">
        {{ link_to("student/showClass/"~classList.id,
        classList.subject.name) }}({{ classList.extraRef }})
    </p>
    {% endfor %}
    </section>
    <section class="ld-subsection">
        <h2>{{ t._("join-class") }}</h2>

        {{ form("student/joinClass", "method":"post", "class":"join-class") }}
        {{ securityTag.csrf(csrf_params) }}
        <p class="col-sm-6">
            {{ select('class-id', classes, 'using': ['id', 'name'],
            'useEmpty': true,
            'emptyText': t._("choose-class"))}}
        </p>
        <p class="col-sm-6">
            <input type="submit" class="btn" value={{ t._("join") }}>
        </p>
        </form>
    </section>
</div>
