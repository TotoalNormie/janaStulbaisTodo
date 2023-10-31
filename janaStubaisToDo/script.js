document.addEventListener('DOMContentLoaded', function () {
    fetchTasks();

    document.getElementById('task-form').addEventListener('submit', function (e) {
        e.preventDefault();
        submitTask();
    });
});
 
const tbody = document.querySelector('tbody');
const editForm = document.getElementById('edit-form');
editForm.onsubmit = updateTask;

function fetchTasks() {
    const taskList = document.getElementById('task-list');

    // Make an AJAX request to fetch tasks
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'task_api.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText)
            const tasks = JSON.parse(xhr.responseText);

            for(elem of tbody.querySelectorAll('tr')) elem.remove();
    
            // Updato table ar fetchotiem taskiem
            tasks.forEach(function (task) {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${task.title}</td>
                <td>${task.description}</td>
                <td>${task.due_date}</td>
                <td>${task.status}</td>
                <td>${task.created_at}</td>
                <td>
                    <button data-id="${task.id}" class="edit-button">Edit</button>
                    <button data-id="${task.id}" class="delete-button">Delete</button>
                </td>`;
                console.log(row);
                tbody.appendChild(row);
            });

            console.log(tbody);

            console.log('works');


            // Addo event listenerus delete buttonam
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const taskId = this.dataset.id;
                    deleteTask(taskId);
                });
            });

            const editButtons = document.querySelectorAll('.edit-button');
            console.log(editButtons);
            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const taskId = this.dataset.id;
                    editTask(taskId);
                })
            })
        }
    };

    xhr.send();
}

function submitTask() {
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const due_date = document.getElementById('due-date').value;
    const status = document.getElementById('status').value;

    if (!title || !status) {
        alert('Title and status are required.');
        return;
    }

    const taskData = {
        title,
        description,
        due_date,
        status
    };

    // AJAX request for new task
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'task_api.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            fetchTasks(); // refresho taskus pēc addošanas
            document.getElementById('task-form').reset(); // Clearo formu
        }
    };

    xhr.send(JSON.stringify(taskData));
}

function editTask(taskId) {
    // Fetch the task data by its ID
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'task_api.php?id=' + taskId, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    console.log(taskId);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const task = JSON.parse(xhr.responseText);
            
            editForm.querySelector('input[name="title"]').value = task.title;
            editForm.querySelector('textarea[name="description"]').value = task.description;
            editForm.querySelector('input[name="due_date"]').value = task.due_date;
            editForm.querySelector('select[name="status"]').value = task.status;
            editForm.querySelector('input[name="id"]').value = task.id;
            editForm.classList.add("foundChungus");
           
            console.log(editForm);
        }
    };

    xhr.send();
}



// Function to update a task
function updateTask(event) {
    event.preventDefault();
    console.log(event);
   const formData = new FormData(event.target);
   console.log(...formData);


    // AJAX request to update the task
    const xhr = new XMLHttpRequest();
    const queryString = new URLSearchParams(formData).toString();
    xhr.open('PUT', 'task_api.php?id=' + formData.get("id"), true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Clear the form and reset the button
            editForm.reset();
            
            // Reload the task list
            fetchTasks();
            editForm.classList.remove("foundChungus");

            console.log(xhr.responseText);
        }
    };

    xhr.send(queryString);
}

// Function to delete a task
function deleteTask(taskId) {
    // Confirm the deletion
    const confirmation = confirm('Are you sure you want to delete this task?');
    if (!confirmation) {
        return;
    }

    // Send an AJAX request to delete the task
    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', 'task_api.php?id=' + taskId, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Reload the task list after deleting
            fetchTasks();
        }
    };

    xhr.send();
}