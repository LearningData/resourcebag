<table>
    <tr>
        <td align="right">
            <label for="Type">{{ t._("type")}}</label>
        </td>
        <td align="left">
            <select name="Type">
                <option value="T" selected="true">Teacher</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="FirstName">{{ t._("name") }}</label>
        </td>
        <td align="left">
            {{ text_field("FirstName", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="LastName">{{ t._("lastname") }}</label>
        </td>
        <td align="left">
            {{ text_field("LastName", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="email">{{ t._("email") }}</label>
        </td>
        <td align="left">
            {{ text_field("email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="confirm-email">Confirm {{ t._("email") }}</label>
        </td>
        <td align="left">
            {{ text_field("confirm-email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="password">{{ t._("password") }}</label>
        </td>
        <td align="left">
            {{ password_field("password", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="confirm-password">Confirm {{ t._("password") }}</label>
        </td>
        <td align="left">
            {{ password_field("confirm-password", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td align="right">
            <h2>Your's school information</h2>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="schoolID">School</label>
        </td>
        <td align="left">
            {{ select('schoolID', schools, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one school') }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="accessCode">Access Code</label>
        </td>
        <td align="left">
            {{ text_field("accessCode", "size" : 30) }}
        </td>
    </tr>
    {{ hidden_field("userID", "type" : "numeric") }}
    {{ securityTag.csrf(csrf_params) }}
    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>
</form>
