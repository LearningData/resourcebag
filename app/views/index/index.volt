<h1>Schoolbag</h1>
{{ form("session/login", "method":"post") }}
<p>{{ text_field("email", "placeholder":"Email") }}</p>
{{ password_field("password","placeholder":"Password" ) }}

{{ submit_button("Login","class":"btn btn-login") }}
{{ link_to("register", "Sign Up","class":"btn btn-login") }}
</form>