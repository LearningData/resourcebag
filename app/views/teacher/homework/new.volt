<div class="homework orange">
    <h2>New homework </h2>

    {{ form("teacher/createHomework", "method":"post", "class":"form inline") }}
        <p class="col-md-6">
            <input type="text" name="title" placeholder="Title:">
        </p>
        <p class="col-md-6">
            <textarea rows="2" cols="300" name="description" placeholder="Description:"></textarea>
        </p>
        <div class="clearfix"></div>
        <p class="col-md-6">
            <input type="text" name="class" disabled="disabled" value="{{ classList.subject.name }}">
        </p>
        <p class="col-md-6">
            <input type="text" name="due-date" id="teacher-due-date" placeholder="Due Date">
        </p>
        <div id="due-times"></div>
        <input type="hidden" name="week-days" id="week-days" value="{{ weekDays }}">
        <input type="hidden" name="class-id" id="class-id"
            value="{{ classList.id }}">
        <h3>Assign students</h3>
        <div id="students">
            <p>{{ check_field("all", "value": true) }} All</p>
            {% for user in classList.users %}
                <p class="col-xs-3">{{ check_field("students[]", "value": user.id) }}
                    {{ user.name }} {{ user.lastName }}</p>
            {% endfor %}
        </div>
        <div class="clearfix"></div>
        <input class="btn" type="submit" value="save">

    </form>
    <button class="btn btn-return">Cancel</button>
</div>
