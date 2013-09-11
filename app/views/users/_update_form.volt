<table>
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
    {{ hidden_field("userID", "type" : "numeric") }}
    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>
</form>