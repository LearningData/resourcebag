<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
        <h2>{{ t._("review") }}</h2>
    </header>
    <section>
        <h3>{{ homework.info.classList.subject.name }} - {{ homework.info.classList.subject.extraRef }} </h3>
        {{ homework.student.name }} {{ homework.student.lastName }}
        <div class="col-sm-12">
            <h4></h4>
        </div>
        <div class="col-sm-12">
            <h6>{{ t._("description") }}</h6>
            <p>
                <strong>{{ homework.info.title }}</strong><br />
                {{ homework.info.text }}
            </p>
        </div>
    </section>
    <section class="homework-text">
        <h3>{{ t._("work-box") }}</h3>
        <div id="homework-text-editor" spellcheck="true" placeholder="{{ t._('enter-homework-text') }}">{{ homework.text }}</div>
    </section>
    <section>
        <h3>{{ t._("work-files") }}</h3>
        {% if homework.files|length != 0 %}
        <table class="table">
            <thead>
                <th>{{ t._("file-name") }}</th>
                <th>{{ t._("description") }}</th>
                <th>{{ t._("download") }}</th>
            </thead>
            {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td class="ld-tooltip">{{ link_to("download/homework/"~file.id,"class":"btn-icon btn-download icon-download", "data-toggle":"tooltip", "title":"Download") }}</td>
            </tr>
            {% endfor %}
        </table>

        {% else %}
        <h3>{{ t._("no-files") }}</h3>
        {% endif %}

    </section>
    {{ form("homework/reviewed/"~homework.id, "method":"post", "class":"form inline") }}
    <div id="hwk-frm-review">
        <label><input type="checkbox" class=""
                 data-target="#hwk-frm-review" data-required-key="one">
                {{ t._("homework-reviewed") }}</label>
        <span class="validation-error">{{ t._("cant-leave-empty") }}</span>
    </div>
    <input type="submit" class="btn mtop-20" value="{{ t._("save") }}">
    <button type="button" class="btn btn-cancel return mtop-20">
        {{ t._("cancel") }}
    </button>
    </form>

</div>
