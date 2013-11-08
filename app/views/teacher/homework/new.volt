<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework")}}</h1>
        <h2>{{ t._("newTitle")}}</h2>
    </header>
    {{ form("teacher/createHomework", "method":"post", "class":"form inline") }}
    <div class="col-sm-9">
        <label for="title">{{ t._("title-label")}}</label>
        <input type="text" name="title" placeholder={{ t._("title-label")}}>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <label for="description">{{ t._("description")}}</label>
        <textarea rows="2" name="description" placeholder={{ t._("description")}}></textarea>
    </div>
    <div class="col-sm-6">
        <label for="class">{{ t._("subject")}}</label>
        <input type="text" name="class" disabled="disabled" value="{{ classList.subject.name }}">
    </div>
    <div class="col-sm-6">
        <label for="due-date">{{ t._("due-date")}}</label>
        <input type="text" name="due-date" id="teacher-due-date" placeholder={{t._("due-date")}}>
    </div>
    <div id="due-times"></div>
    <input type="hidden" name="week-days" id="week-days" value="{{ weekDays }}">
    <input type="hidden" name="class-id" id="class-id"
    value="{{ classList.id }}">
    <h3>{{ t._("assign-students") }}</h3>
    <div id="students" class="ld-tree">
        <p>
            {{ check_field("all", "value": true, "class":"parent-node", "data-target":".ld-homework .student-node", "checked":"checked") }} {{ t._("all") }}
        </p>
        {% for user in classList.users %}
        <p class="col-xs-3">
            {{ check_field("students[]", "value": user.id, "checked":"checked", "class":"student-node child-node", "data-source":".ld-homework .parent-node" ) }}
            {{ user.name }} {{ user.lastName }}
        </p>
        {% endfor %}
    </div>
    <div class="clearfix"></div>
    <input class="btn" type="submit" value={{ t._("save")}}>

    </form>
    <button class="btn btn-return btn-cancel">
        {{ t._("cancel")}}
    </button>
</div>
