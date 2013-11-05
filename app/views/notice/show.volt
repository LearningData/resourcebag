<div class="blue">
<h1>Notice</h1>
<p>
    {{ notice.getDate() }} <br />
    {{ notice.author.name }} {{ notice.author.lastName }}
</p>
<p><strong>Message: </strong>{{ notice.text }}</p>

{% for file in notice.files %}
    <p>{{ link_to("download/noticeboard/"~file.id, "Download") }}</p>
{% endfor %}

</div>