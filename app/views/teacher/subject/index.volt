{% include "teacher/_header.volt" %}

<h1>Subjects</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Class</th>
            <th>Year</th>
            <th>Students</th>
        </tr>
    </thead>
    <tbody>
    {% for listClass in classes %}
        <tr>
            <td>
                <a href="#">
                    {{listClass.subject.name }} ({{ listClass.extraRef }}) </td>
                </a>
            <td>{{ listClass.year }}</td>
            {% if listClass.users.count() %}
                <td>
                    <a data-toggle="modal" href="#modal{{ listClass.id }}">
                        {{ listClass.users.count() }}
                    </a>
                    <div class="modal fade"
                        id="modal{{ listClass.id}}"
                        role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Users</h4>
                            </div>
                            <div class="modal-body">
                                {% for user in listClass.users %}
                                    <p>{{ user.name }}</p>
                                {% endfor %}
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                </td>
            {% else %}
                <td>{{ listClass.users.count() }}</td>
            {% endif %}
        </tr>
    {% endfor %}
    </tbody>
</table>