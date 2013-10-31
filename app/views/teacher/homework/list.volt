<div class="homework orange">
    <h2>Homework</h2>
    {% if classes %}

    <table class="table table-hover fixed">
        <thead>
            <tr>
                <th colspan=7 rowspan=2>Class</th>
                <th rowspan=2></th>
                <th colspan=1 rowspan=2>Year</th>
                <th colspan=1 rowspan=2>Students</th>
                <th colspan=2>Status</th>
                <th colspan=1 rowspan=2>Actions</th>
                
            </tr>
            <tr>
                <th>In Progress</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
        {% for classList in classes %}
            <tr>
                <td colspan=7>{{ classList.subject.name~"("~classList.extraRef~")" }}
                </td>
                <td>{{ link_to("teacher/homework/new/"~classList.id, "New") }}</td>
                <td>{{ classList.cohort.stage }}</td>
                <td>{{ classList.users.count() }}</td>
                <td>{{ classList.getPendingHomework().count() }}</td>
                <td>{{ classList.getSubmittedHomework().count() }}</td>
                <td>
                    {% if !classList.getSubmittedHomework().count() %}
                        <span data-title="{{ homework.title }}" class="btn-inactive btn-edit btn-icon icon-pencil" title="No pending homework"></span>
                    {% else %}
                        {{ link_to("teacher/homework/class/"~classList.id~"?filter=2", "class":"btn-icon btn-edit icon-pencil", "title":"Review") }}
                    {% endif %}

                    {{ link_to("teacher/homework/class/"~classList.id~"?filter=3", "class":"btn-review btn-icon icon-eye-open", "title":"View archive") }}
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    {% else %}

    {{ form("homework/reviewManyHomeworks", "method":"post", "class":"form inline") }}
        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Homework</th>
                    <th>Assigned Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
            {% for homework in page.items %}
                <tr>
                    <td>{{ homework.student.name }} {{ homework.student.lastName }}</td>
                    <td>{{ homework.title }}</td>
                    <td>{{ homework.setDate }}</td>
                    <td>{{ homework.dueDate }}</td>
                    {% if homework.isSubmitted() %}
                        <td>
                            {{ link_to("teacher/homework/review/"~homework.id, "Review") }}
                        </td>
                        <td>
                            <input type="checkbox"
                                name="ids[]" value="{{ homework.id }}">
                        </td>
                    {% else %}
                        <td>
                        {% if homework.isReviewed() %}
                            {{ link_to("teacher/homework/show/"~homework.id, "View") }}
                        {% else %}
                            {{ homework.getStatus() }}
                        {% endif %}
                        </td>
                        </td></td>
                    {% endif %}
                </tr>
            {% endfor %}
            </tbody>
        </table>
        <ul class="paginator homework">
            <li>{{ link_to("teacher/homework?page="~page.before~"&filter="~status, "class":"icon-chevron-left Prev") }}</li>
            {% for link in links %}
                <li>{{ link_to(link['url'], link['page']) }}</li>
            {% endfor %}
            <li>{{ link_to("teacherhomework?page="~page.next~"&filter="~status, "class":"icon-chevron-right Next") }}</li>
        </li>
        </ul>
        <input type="submit" class="btn btn-left">
    </form>
    <button class="btn btn-return">Cancel</button>
    {% endif %}
</div>
