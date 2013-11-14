<div class="ld-classes pink">
    <header>
        <h1 data-target="ld-classes">{{ t._("classes") }}</h1>
    </header>
    <section class="col-md-12">
        <h2 class="subheader">{{ classList.subject.name }}</h2>
        <p class="col-md-6">
            <span class="label">{{ t._("teacher") }}</span>
            {{ t._(classList.user.title) }}  {{ classList.user.lastName }}
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
    <section class="homework col-md-6">
        <h2>{{ t._("homework") }}</h2>
        <!--<h3>{{ t._("overdue") }}</h3>-->
        {% for homework in homeworks if homework.status == 0 %}
        <h3 class="pending">{{ t._("pending") }}</h3>
        <ul class="pending">
            {% for homework in homeworks if homework.status == 0 %}
            <li class="item">
                <span class="date">{{ homework.getDueDate(t._("dateformat")) }}</span>
                <span class="title">{{ link_to("student/homework/start/"~homework.id, homework.title)  }}</span>
                <span class="description">{{ homework.text }}</span>
            </li>
            {% endfor %}
        </ul>
        {% break %}
        {% endfor %}

        {% for homework in homeworks if homework.status == 1 %}
        <h3 class="in-progress">{{ t._("in-progress") }}</h3>
        <ul  class="in-progress">
            {% for homework in homeworks if homework.status == 1 %}
            <li class="item">
                <span class="date">{{ homework.getDueDate(t._("dateformat")) }}</span>
                <span class="title">{{ link_to("student/homework/edit/"~homework.id, homework.title)  }}</span>
                <span class="description">{{ homework.text }}</span>
            </li>
            {% endfor %}
        </ul>
        {% break %}
        {% endfor %}
    </section>
</div>
