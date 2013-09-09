<table>
    <tr>
        <td align="right">
            <label for="userID">UserID</label>
        </td>
        <td align="left">
            {{ text_field("userID", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="schoolID">SchoolID</label>
        </td>
        <td align="left">
            {{ text_field("schoolID", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="year">Year</label>
        </td>
        <td align="left">
            {{ text_field("year", "type" : "numeric") }}
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
            <label for="Type">Type</label>
        </td>
        <td align="left">
                {{ text_field("Type") }}
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
            <label for="password">Password</label>
        </td>
        <td align="left">
            {{ text_field("password", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>
</form>
