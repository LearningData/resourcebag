{{ form("policies/upload", "method":"post", "enctype":"multipart/form-data") }}
    <input type="file" name="file">
    {{ submit_button("Upload") }}
</form>