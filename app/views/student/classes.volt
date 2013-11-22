<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes")  }}</h1>
    </header>
    <section class="classes">
        <h3>{{ t._("my-classes") }}</h3>
    {% for classList in user.classes %}
    <div class="col-xs-4 col-md-3 class">
        <div class="class-item" data-class-id="{{ classList.id }}">
            {{ classList.subject.name }}
            <span class="extra-info">{{ classList.user.title }} {{ classList.user.lastName }}</span>
            <span class="extra-info">{{ classList.extraRef }}</span>
        </div>
    </div>
    {% endfor %}
    </section>
    <section>
        <h3>{{ t._("join-class") }}</h3>

        {{ form("student/joinClass", "method":"post", "class":"join-class") }}
        {{ securityTag.csrf(csrf_params) }}
        <p class="col-sm-6" id="cls-frm-class">
            {{ select('class-id', classes, 'using': ['id', 'name'],
            'useEmpty': true, 'emptyText': t._("choose-class"),
            'data-required-key': 'true', 'data-target':'#cls-frm-class')}}
            <span class="validation-error">{{ t._("select-a-class") }}</span>
        </p>
        <p class="col-sm-6">
            <input type="submit" class="btn" value={{ t._("join") }}>
        </p>
        </form>
    </section>
</div>
