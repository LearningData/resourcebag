<p>
    <label for="old-password">{{ t._("Old Password") }}</label>
    <input type="password" name="old-password">
</p>
<p>
    <label for="new-password">{{ t._("New Password") }}</label>
    <input type="password" name="new-password">
</p>
<p>
    <label for="confirm-new-password">{{ t._("Confirm New Password") }}</label>
    <input type="password" name="confirm-new-password">
</p>
{{ securityTag.csrf(csrf_params) }}
<p>
<input type="submit" value="{{ t._("save") }}" class="btn">
</p>
</form>
<p>
<button type="button" class="btn btn-cancel">
    {{ t._("cancel") }}
</button>
</p>
