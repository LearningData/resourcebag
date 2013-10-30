<p>
    <label for="name">Name</label>
    <input type="text" name="name">
</p>
<p>
    <label for="value">Value</label>
    <input type="text" name="value">
</p>
{{ securityTag.csrf(csrf_params) }}
<p>
    <input type="submit">
</p>

</form>
