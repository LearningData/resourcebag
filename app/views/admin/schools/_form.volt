<table>
    <tr>
        <td align="right">
            <label for="SchoolName">SchoolName</label>
        </td>
        <td align="left">
            {{ text_field("SchoolName", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="Address">Address</label>
        </td>
        <td align="left">
            {{ text_field("Address", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="SchoolPath">SchoolPath</label>
        </td>
        <td align="left">
            {{ text_field("SchoolPath", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="AccessCode">AccessCode</label>
        </td>
        <td align="left">
            {{ text_field("AccessCode", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="TeacherAccessCode">TeacherAccessCode</label>
        </td>
        <td align="left">
            {{ text_field("TeacherAccessCode", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="allTY">AllTY</label>
        </td>
        <td align="left">
            {{ text_field("allTY", "type" : "numeric") }}
        </td>
    </tr>
        {{ hidden_field("schoolID", "type" : "numeric") }}
        {{ securityTag.csrf(csrf_params) }}
    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>
</form>
