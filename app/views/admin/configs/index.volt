{% include "admin/_header.volt" %}

<h1>Listing Configurations</h1>

{% for config in configs %}
    <p>
        {{config.name }} - {{ config.value }}
        {{ link_to("admin/deleteConfig/"~config.id, "Delete")}}
    </p>
{% endfor %}