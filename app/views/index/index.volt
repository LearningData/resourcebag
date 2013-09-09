<h1>Schoolbag</h1>
{{ content() }}
{{ form("session/login", "method":"post") }}
<p><label for="email">Email:</label></p>
<p>{{ text_field("email") }}</p>
<p><label for="password">Password:</label></p>
<p>{{ password_field("password") }}</p>
<p>{{ submit_button("Save") }}</p>
</form>