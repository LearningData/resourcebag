<div class="ld-homework orange">
    <h1>{{ homework.title }} ({{ homework.student.name }})</h1>

    <section class="homework-view">
        <table class="table homework">
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
                        <td>{{ link_to("download/homework/"~file.id,"class":"btn-icon btn-download icon-download") }}</td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
        {{ form("homework/reviewed/"~homework.id, "method":"post", "class":"form inline") }}
            <input type="submit" class="btn">
        </form>
        <button class="btn return">Back</button>
    </section>
</div>
