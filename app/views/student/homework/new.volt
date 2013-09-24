<h2>New {{ classList.subject.name }} homework </h2>

<form action="/schoolbag/student/createHomework" method="post">
    <p>
        <label>Homework</label>
        <textarea rows="4" cols="300" name="description"></textarea>
    </p>
    <p>
        <label>Class</label>
        <input type="text" name="subject-name"
            value="{{ classList.subject.name }} ({{ classList.extraRef}})"
            disabled="true">
    </p>
    <p>
        <label>Due Date</label>
        <input type="text" name="due-date" id="due-date">
    </p>
    <input type="hidden" name="week-days" value="{{ weekDays }}" id="week-days">
    <input type="hidden" name="class-id" value="{{ classList.id }}">
    <input type="hidden" name="teacher-id" value="{{ classList.teacherId }}"
    <p><input type="submit"></p>
</form>