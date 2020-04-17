<?php
include('connection.php');
$request_method = $_SERVER['REQUEST_METHOD'];
$connection = openConn();
switch ($request_method) {
    case 'GET':
        if ($_GET['action'] == "employee") {
            if (!empty($_GET['id'])) {
                getEmployee($connection, intval($_GET['id']));
            } else {
                getEmployee($connection);
            }
        }else{
            getRole($connection);
        }
        break;

    case 'POST':
        insertEmployee($connection);
        break;

    case 'PUT':
        updateEmployee($connection, intval($_GET['id']));
        break;

    case 'DELETE':
        deleteEmployee($connection, intval($_GET['id']));
        break;

    default:
        header("Method not allowed");
        break;
}

function getRole($connection){
    $query = "SELECT * FROM role";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    header('json app');
    echo json_encode($response);
}

function getEmployee($connection, $id = 0)
{
    $query = "SELECT * FROM employee, role WHERE employee.role_employee = role.id_role";

    if ($id != 0) {
        $query .= " AND employee.id_employee = $id";
    }

    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    header('json app');
    echo json_encode($response);
}

function insertEmployee($connection)
{
    $post_vars = json_decode(file_get_contents("php://input"), true);
    $name = $post_vars['name'];
    $email = $post_vars['email'];
    $role = $post_vars['role'];
    $query = "INSERT INTO `employee` (`id_employee`, `name_employee`, `email_employee`, `role_employee`) VALUES (NULL, '$name', '$email', '$role');";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 200,
            'status_message' => 'Success Insert'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Insert'
        );
    }
    header('json app');
    echo json_encode($response);
}

function updateEmployee($connection, $id=0){
    $post_vars = json_decode(file_get_contents("php://input"), true);
    $name = $post_vars['name'];
    $email = $post_vars['email'];
    $role = $post_vars['role'];
    $query = "UPDATE `employee` SET `name_employee` = '$name', `email_employee` = '$email', `role_employee` = '$role' WHERE `employee`.`id_employee` = $id; ";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 200,
            'status_message' => 'Success Update'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Update'
        );
    }
    header('json app');
    echo json_encode($response);
}

function deleteEmployee($connection, $id=0){
    $query = "DELETE FROM employee WHERE employee.id_employee = $id";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 200,
            'status_message' => 'Success Delete'
        );
    }else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed Delete'
        );
    }
    header('json app');
    echo json_encode($response);
}