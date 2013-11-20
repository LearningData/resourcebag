<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework")}}</h1>
        <h2>{{ t._("newTitle")}}</h2>
    </header>
{{ form("teacher/createHomework", "method":"post", "class":"form inline") }}
    <section class="ld-subsection first">
        <h3>{{ t._("homework") }}</h3>
        <div class="row">
            <div class="col-sm-6" id="hwk-frm-title">
                <label for="title">{{ t._("title-label")}}</label>
                <input type="text" name="title" 
                    placeholder={{ t._("title-label")}}
                    data-required-key="true" data-target="#hwk-frm-title">
                <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12" id="hwk-frm-desc">
                <label for="description">{{ t._("description")}}</label>
                <textarea rows="5" name="description" placeholder={{ t._("description")}}
                data-required-key="true" data-target="#hwk-frm-desc"></textarea>
                <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
            </div>
            <div class="col-sm-6" id="hwk-frm-due-date">
                <label for="due-date">{{ t._("due-date")}}</label>
                <input type="text" name="due-date" id="teacher-due-date" placeholder={{t._("due-date")}}
                data-required-key="date" data-target="#hwk-frm-due-date"></textarea>
                <span class="validation-error">{{ t._("needs-date") }}</span>
            </div>
            <div class="col-sm-6">
                <label for="class">{{ t._("subject")}}</label>
                <input type="text" name="class" disabled="disabled" value="{{ classList.subject.name }}">
            </div>
            <div class="col-sm-12">
                <div id="due-times"></div>
            </div>
            <input type="hidden" name="week-days" id="week-days" value="{{ weekDays }}">
            <input type="hidden" name="class-id" id="class-id"
            value="{{ classList.id }}">
        </div>
    </section>
    <section class="ld-subsection">
        <h3>{{ t._("assign-students") }}</h3>
        <div id="hwk-frm-student" class="ld-tree">
            <p>
                {{ check_field("all", "value": true, "class":"parent-node",
                    "data-target":".ld-homework .student-node",
                    "checked":"checked", "data-required-key":"one",
                    "data-target":"#hwk-frm-student") }} {{ t._("all") }}
            </p>
            {% for user in classList.users %}
            <p class="col-xs-3">
                {{ check_field("students[]", "value": user.id,
                 "checked":"checked",  "data-required-key":"one",
                 "data-target":"#hwk-frm-student",
                 "class":"student-node child-node", "data-source":".ld-homework .parent-node" ) }}
                {{ user.name }} {{ user.lastName }}
            </p>
            {% endfor %}
            <span class="validation-error">{{ t._("select-least-one") }}</span>
        </div>
        <div class="clearfix"></div>
        <input class="btn mtop-20" type="submit" value={{ t._("save")}}>
        <button class="btn btn-return btn-cancel mtop-20">
            {{ t._("cancel")}}
        </button>
    </section>
    </form>
</div>
