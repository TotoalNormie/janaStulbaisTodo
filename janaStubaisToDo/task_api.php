<?php
require_once 'db.php';

class TaskAPI {
    private $db;

    function __construct() {
        $this->db = new TaskDB();
    }

    function getAllTasks() {
        try {
            $tasks = $this->db->getAllTasks();
            echo json_encode($tasks);
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to retrieve tasks.'));
        }
    }

    function getTaskById($id) {
        try {
            $task = $this->db->getTaskById($id);
            echo json_encode($task);
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to retrieve the task.'));
        }
    }

    function createTask($title, $description, $due_date, $status) {
        try {
            $result = $this->db->createTask($title, $description, $due_date, $status);
            echo json_encode(array('message' => 'Task created successfully'));
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to create the task.'));
        }
    }

    function updateTask($id, $title, $description, $due_date, $status) {
        try {
            $result = $this->db->updateTask($id, $title, $description, $due_date, $status);
            echo json_encode(array('message' => 'Task updated successfully'));
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to update the task.'));
        }
    }

    function deleteTask($id) {
        try {
            $result = $this->db->deleteTask($id);
            echo json_encode(array('message' => 'Task deleted successfully'));
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to delete the task.'));
        }
    }
}

$api = new TaskAPI();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Handle GET request for a specific task
        $api->getTaskById($_GET['id']);
    } else {
        // Handle GET request for all tasks
        $api->getAllTasks();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request to create a new task
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'];
    $description = $data['description'];
    $due_date = $data['due_date'];
    $status = $data['status'];

    $api->createTask($title, $description, $due_date, $status);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Handle PUT request to update an existing task
    parse_str(file_get_contents("php://input"), $data);

    print_r($data);
   
    $id = $_GET['id'];
    $title = $data['title'];
    $description = $data['description'];
    $due_date = $data['due_date'];
    $status = $data['status'];

    $api->updateTask($id, $title, $description, $due_date, $status);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Handle DELETE request to delete a task
    $id = $_GET['id'];
    $api->deleteTask($id);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}
?>