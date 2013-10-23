<h1>{{ classList.subject.name }}</h1>
    <p class="col-md-6">
        <span class="label">Teacher</span>
        {{ classList.user.name }}   {{ classList.user.lastName }}
    </p>
    <p class="col-md-6">
        <span class="label">Cohort</span>
        {{ classList.cohort.stage }}
    </p>
    <p class="col-md-6">
        <span class="label">Room</span>
        {{ classList.room }}
    </p>
    <p class="col-md-6">
        <span class="label">Extra Ref</span>
        {{ classList.extraRef }}
    </p>
<hr/>
<h2>Times</h2>
<hr/>
<h2>Students</h2>

{% for student in classList.users %}
    <p>{{ student.name }} {{ student.lastName }}</p>
{% endfor %}
