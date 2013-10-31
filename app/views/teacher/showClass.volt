<div class="classes pink">
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
    <h2>Resources</h2>
    <p>Here is where you can add/find links to material and web services of use in the class.</p>
    <h2>Students <input class="filter" type="text" placeholder="Filter"></h2>
    {% for student in classList.users %}
        <p class="col-xs-3">{{ student.name }} {{ student.lastName }}</p>
    {% endfor %}
</div>
