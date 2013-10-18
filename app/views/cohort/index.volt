<h1>Listing Cohorts</h1>
<h3>{{ link_to("cohort/new", "New") }}</h3>

{% for cohort in cohorts %}
    <p>
        {{ cohort.stage }}
         {{ link_to("cohort/edit/"~cohort.id, "Edit")}}
         {{ link_to("cohort/remove/"~cohort.id, "Remove") }}
    </p>
{% endfor %}