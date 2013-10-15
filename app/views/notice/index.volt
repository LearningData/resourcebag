<h1>School Notice Board</h1>

{% if not user.isStudent() %}
{{ link_to(user.getController()~"/noticeboard/new", "New") }}
{% for notice in notices %}
<p>
    <strong>Message: </strong>{{ notice.text }}
</p>
<p>
    <strong>Author: </strong>
    {{ notice.author.name }} {{ notice.author.lastName }}
</p>
{% for file in notice.files %}
<p>
    {{ link_to("download/noticeboard/"~file.id, "Download") }}
</p>
{% endfor %}
<p>
    {% if user.id == notice.author.id %}
    {{ link_to(user.getController()~"/noticeboard/edit/"~notice.id, "Edit") }}
    {% endif %}
</p>
<p>
    {{ link_to(user.getController()~"/noticeboard/show/"~notice.id, "Show")}}
</p>
<p>
    {{ notice.getDate() }}
</p>
{% endfor %}
{% else %}
<!--div class="gridster student notice-page">
<ul>
<li id = "ntebrd1" class="note" data-row=1 data-col=1 data-sizex=6 data-sizey=6></li>
<li id = "ntebrd2" class="note" data-row=1 data-col=7 data-sizex=3 data-sizey=6></li>
<li id = "ntebrd3" class="note" data-row=7 data-col=1 data-sizex=3 data-sizey=2></li>
<li id = "ntebrd4" class="note" data-row=7 data-col=4 data-sizex=3 data-sizey=2></li>
<li id = "ntebrd5" class="note" data-row=7 data-col=7 data-sizex=3 data-sizey=2></li>
</ul>
</div-->
{% endif %}

<!--exemple to use collum inside collum-->


<div class="student notice-page">
    <ul>
        <li id = "ntebrd1" class="note note-lvl1 col-md-8">
            <h2>Cake Event next weekend</h2>
            <span>31/10/13 - 11:00
                <br />
                Mr Old</span>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum molestie porttitor. Nulla ac placerat magna, ac molestie eros.
            </p>
        </li>
        <li id = "ntebrd2" class="note note-lvl2 col-md-4">
            <h3>Ice Cream Event next Sunday</h3>
            <span>31/10/13 - 11:00
                <br />
                Mr Old</span>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum molestie porttitor. Nulla ac placerat magna, ac molestie eros.
            </p>
        </li>
        <li id = "ntebrd3" class="note note-lvl3 col-md-4">
            <h4>Ice Cream Event next Sunday</h4>
            <span>31/10/13 - 11:00
                <br />
                Mr Old</span>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum molestie porttitor. Nulla ac placerat magna, ac molestie eros.
            </p>
        </li>
        <li id = "ntebrd4" class="note note-lvl3 col-md-4">
            <h4>Ice Cream Event next Sunday</h4>
            <span>31/10/13 - 11:00
                <br />
                Mr Old</span>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum molestie porttitor. Nulla ac placerat magna, ac molestie eros.
            </p>
        </li>
        <li id = "ntebrd5" class="note note-lvl3 col-md-4">
            <h4>Ice Cream Event next Sunday</h4>
            <span>31/10/13 - 11:00
                <br />
                Mr Old</span>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum molestie porttitor. Nulla ac placerat magna, ac molestie eros.
            </p>
        </li>
    </ul>
</div>
