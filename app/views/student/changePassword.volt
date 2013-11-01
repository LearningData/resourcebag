<div class="orange">
    <h1>Change your password</h1>
    {{ form("student/updatePassword", "method":"post") }}
    {% include "users/_password_fields.volt" %}
    </form>
</div>