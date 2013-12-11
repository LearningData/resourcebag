<div class="ld-resources blue">
    <header>
        <h1>{{ t._("resources") }}</h1>
    </header>
    {% if not user.isStudent() %}
        {{ link_to("resources/new", t._("add-resource"),
        "class":"btn") }}
    {% endif %}
    <section>
        <h3>{{ t._("my-resources") }}</h3>
        <ul>
        {% for key, classList in classes %}
            <li><span class="collapse-toggle" data-icon="#icon{{ key }}" data-target="#resrc{{ key }}"><span id="icon{{ key }}"class="collapse-icon-close">{{ classList["name"] }}
                <span id="resrc{{ key }}" class="collapse">
                {% for resource in classList["resources"] %}
                    <p>{{ image("img/icons/icon-file-generic.png") }}
                        {{ link_to("resources/download/"~resource.id, resource.fileName) }}
                        {% for resourceTag in resource.properties %}
                            / {{ resourceTag.type }}
                        {% endfor %}
                    </p>
                {% endfor %}
                </span>
            </li>
        {% endfor %}
        </ul>
    </section>
</div>
