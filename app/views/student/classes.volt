<div class="ld-classes pink">
    <h1 class="header">Classes</h1>
    {% for classList in user.classes %}
        <p class="col-xs-3">{{ link_to("student/showClass/"~classList.id,
            classList.subject.name) }}({{ classList.extraRef }})
        </p>
    {% endfor %}
    <div class="clearfix"></div>
    <button class="btn join-class">Join Class</button>

    {{ form("student/joinClass", "method":"post", "class":"join-class hidden") }}
        {{ securityTag.csrf(csrf_params) }}
        <p>
            {{ select('class-id', classes, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one class')}}
        </p>
        <p>
            <input type="submit" class="btn" value="Submit">
            <button type="button" class="btn btn-cancel">Cancel</button>
        </p>
    </form>
</div>
