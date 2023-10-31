<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="chungtainer">
        <h1>Task Management</h1>
        <form id="task-form">
            <input type="text" id="title" placeholder="Title" required>
            <textarea id="description" placeholder="Description"></textarea>
            <input type="date" id="due-date">
            <select id="status">
                <option value="To Do">To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="Done">Done</option>
            </select>
            <button type="submit">Add Task</button>
        </form>
        <table id="task-list">
            <thead>
                <tr>
                    <td>title</td>
                    <td>description</td>
                    <td>due_date</td>
                    <td>status</td>
                    <td>created_at</td>
                    <td>
                        Edit and delete
                    </td>
                </tr>
            </thead>
            <tbody>
                <!-- Task list will be displayed here -->
            </tbody>
        </table>
    </div>


    <form id="edit-form">
        <input type="hidden" name="id">
        <input type="text" name="title" placeholder="Title" required>
        <textarea placeholder="Description" name="description"></textarea>
        <input type="date" name="due_date">
        <select name="status">
            <option value="To Do">To Do</option>
            <option value="In Progress">In Progress</option>
            <option value="Done">Done</option>
        </select>
        <button type="submit">Update Task</button>
    </form>
    <script src="script.js"></script>
</body>

</html>