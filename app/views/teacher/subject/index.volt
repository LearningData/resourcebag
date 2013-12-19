<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
    </header>
    <div class="col-sm-12 ld-new-buttons">
        <a href="/schoolbag/teacher/newClass"><span class="custom-icon-new-homework"></span>{{ t._("new-class") }}</a>
        <hr />
    </div>
    <table class="table mtop-20">
        <thead>
            <tr>
                <th>{{ t._("class") }}</th>
                <th>{{ t._("students") }}</th>
                <th></th>
            </tr>
        </thead>
       <tbody>
<!--            {% if classes is type('object') %}
            {% endif %}
-->            {% for classList in classes %}
            <tr>
                <td> {{ link_to("teacher/showClass/"~classList.id, classList.subject.name~"    "~classList.extraRef) }} </td>
                <td class="ld-student-status">{{ classList.users.count() }}</td>
                <td class="ld-tooltip"><span class="link remove-class btn-icon icon-remove" data-class-id="{{ classList.id }}" data-toggle="tooltip" title="{{ t._("remove-class") }}"></span>
                {{ link_to("teacher/editClass/"~classList.id,"class":"btn-icon btn-edit icon-pencil")}} </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
