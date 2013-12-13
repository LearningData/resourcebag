<div class="ld-classes pink" data-colour="pink" data-title="{{ t._("classes")  }}">
    <header>
        <h1>{{ t._("classes")  }}</h1>
    </header>

     {% for classList in user.classes %}
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 class class-item" data-class-id="{{ classList.id }}">
            <div class="thumb-classes">{{ image("img/art-temp.jpg") }} </div>
            <p class="subject"><strong>{{ classList.subject.name }}</strong></p>
            <p class="extra-info">
                {{ classList.user.title }} {{ classList.user.lastName }}
                {{ classList.extraRef }}
            </p>
        </div>
    {% endfor %}
    
    
    
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
