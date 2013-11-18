<div class="classes pink">
    <header>
        <h1>{{ t._("classes") }}</h1>
        <h2>{{ t._("edit-class") }}</h1>
    </header>
    {{ form("teacher/updateClass", "method":"post", "class":"form-inline") }}
        {{ partial("teacher/_classForm")}}
    </form>

</div>