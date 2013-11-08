<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
    </header>
    {{ link_to("teacher/newClass", t._("create-new-class"), "class":"btn") }}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ t._("class") }}</th>
                <th>{{ t._("cohort") }}</th>
                <th>{{ t._("students") }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            {% for classList in classes %}
            <tr>
                <td> {{ link_to("teacher/showClass/"~classList.id,
                classList.subject.name~"("~classList.extraRef~")") }} </td>
                <td>{{ classList.cohort.stage }}</td>
                {% if classList.users.count() %}
                <td><a data-toggle="modal" href="#modal{{ classList.id }}"> {{ classList.users.count() }} </a> {% include "teacher/modal_users.volt" %} </td>
                {% else %}
                <td>{{ classList.users.count() }}</td>
                {% endif %}
                <td><span class="link remove-class" data-class-id="{{ classList.id }}">{{ t._("remove-class") }}</span></td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
