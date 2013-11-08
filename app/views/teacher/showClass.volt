<div class="ld-classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
    </header>
    <section>
        <h2 class="subheader">{{ classList.subject.name }}</h2>
        <p class="col-md-6">
            <span class="label">{{ t._("teacher") }}</span>
            {{ classList.user.name }}   {{ classList.user.lastName }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("cohort") }}</span>
            {{ classList.cohort.stage }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("room") }}</span>
            {{ classList.room }}
        </p>
        <p class="col-md-6">
            <span class="label">{{ t._("extra-ref") }}</span>
            {{ classList.extraRef }}
        </p>
        <hr/>
    </section>
    <section>
        <h2>{{ t._("times") }}</h2>
    </section>
    <section>
        <h2>{{ t._("resources") }}</h2>
        <p>
            Here is where you can add/find links to material and web services of use in the class.
        </p>
    </section>
    <section  class="student-list">
        <h2>{{ t._("students") }}</h2>
        <input class="filter" type="text" placeholder="Filter student list">
        {% for student in classList.users %}
        <p class="col-xs-3">
            {{ student.name }} {{ student.lastName }}
        </p>
        {% endfor %}
    </section>
    <div class="clearfix"></div>
</div>
