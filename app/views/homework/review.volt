<div class="ld-homework orange">
    <header>
        <h1>{{ t._("homework") }}</h1>
        <h2>{{ t._("review") }}</h2>
        
    </header>
    <h3>{{ homework.title }} ({{ homework.student.name }})</h3>
    <table class="table homework mtop-20">
        <thead>
            <th>File Name</th>
            <th>Descritpion</th>
            <th>Download</th>
        </thead>
        <tbody>
            {% for file in homework.files %}
            <tr>
                <td>{{ file.originalName }}</td>
                <td>{{ file.description }}</td>
                <td class="ld-tooltip">{{ link_to("download/homework/"~file.id,"class":"btn-icon btn-download icon-download", "data-toggle":"tooltip", "title":"Download") }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
    {{ form("homework/reviewed/"~homework.id, "method":"post", "class":"form inline") }}
    <input type="submit" class="btn mtop-20" value="{{ t._("submit") }}">
    <button type="button" class="btn btn-cancel return mtop-20">
        {{ t._("back") }}
    </button>
    </form>

</div>
