{% include "teacher/_header.volt" %}

<h1>New Class</h1>

<form action="/schoolbag/teacher/createClass" method="post">
    <p>
        <label for="subject-id">Subject</label>
        {{ select('subject-id', subjects, 'using': ['id', 'name'],
                'emptyText': 'Please, choose one subject') }}
    </p>
    <p>
        <label for="year">Year</label>
        <input type="text" name="year">
    </p>
    <p>
        <label for="extra-ref">Extra Ref</label>
        <input type="text" name="extra-ref">
    </p>
    <p>
        <label for="schyear">School Year: {{ schoolYear.value }}</label>
        <input type="hidden" name="schyear" value="{{ schoolYear.value }}">
    </p>

    <input type="submit">
</form>