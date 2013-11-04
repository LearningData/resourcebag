<p>
    <label for="old-password">Old Password</label>
    <input type="password" name="old-password">
</p>
<p>
    <label for="new-password">New Password</label>
    <input type="password" name="new-password">
</p>
<p>
    <label for="confirm-new-password">Confirm New Password</label>
    <input type="password" name="confirm-new-password">
</p>
{{ securityTag.csrf(csrf_params) }}
<p>
<input type="submit" value="save" class="btn">
</p>
</form>
<p>
<button class="btn btn-cancel">
    Cancel
</button>
</p>