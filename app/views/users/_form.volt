<table>
    <tr>
        <td align="right">
            <label for="Type">Type</label>
        </td>
        <td align="left">
            <select name="Type">
                <option value="T">Teacher</option>
                <option value="S" selected="true">Student</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="FirstName">FirstName</label>
        </td>
        <td align="left">
            {{ text_field("FirstName", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="LastName">LastName</label>
        </td>
        <td align="left">
            {{ text_field("LastName", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="email">Email</label>
        </td>
        <td align="left">
            {{ text_field("email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="confirmEmail">Confirm Email</label>
        </td>
        <td align="left">
            {{ text_field("confirmEmail", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="password">Password</label>
        </td>
        <td align="left">
            {{ password_field("password", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="confirmPassword">Confirm Password</label>
        </td>
        <td align="left">
            {{ password_field("password", "size" : 30) }}
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
    <tr>
        <td align="right">
            <label for="year">Year/Class</label>
        </td>
        <td align="left">
        <select name="year">
            <option value="-1">Juniors</option>
            <option value="0">Seniors</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
        </td>
    </tr>
    {{ hidden_field("userID", "type" : "numeric") }}
    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>
</form>
