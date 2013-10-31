<div class="ld-classes pink">
    <h1 class="header">Classes</h1>
    {{ link_to("teacher/newClass", "Create a New Class", "class":"btn") }}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Class</th>
                <th>Year</th>
                <th>Students</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        {% for classList in classes %}
            <tr>
                <td>
                    {{ link_to("teacher/showClass/"~classList.id,
                        classList.subject.name~"("~classList.extraRef~")") }}

                </td>
                <td>{{ classList.cohort.stage }}</td>
                {% if classList.users.count() %}
                    <td>
                        <a data-toggle="modal" href="#modal{{ classList.id }}">
                            {{ classList.users.count() }}
                        </a>
                        {% include "teacher/modal_users.volt" %}
                    </td>
                {% else %}
                    <td>{{ classList.users.count() }}</td>
                {% endif %}
                <td>
                    <span class="link remove-class" data-class-id="{{ classList.id }}">Remove this class</span>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
</div>
