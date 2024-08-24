<?php 
include('../server/server.php');

if(!isset($_SESSION['username'])){
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}

$purok  = $conn->real_escape_string($_POST['purok']);
$details = isset($_POST['details']) ? $conn->real_escape_string($_POST['details']) : ''; // Allow details to be empty

if(!empty($purok)){

    $insert  = "INSERT INTO tblpurok (`name`, `details`) VALUES ('$purok', '$details')";
    $result  = $conn->query($insert);

    if($result === true){
        $_SESSION['message'] = 'Purok added!';
        $_SESSION['success'] = 'success';

    }else{
        $_SESSION['message'] = 'Something went wrong! Error: ' . $conn->error;
        $_SESSION['success'] = 'danger';
    }

}else{

    $_SESSION['message'] = 'Please fill up the form completely!';
    $_SESSION['success'] = 'danger';
}

header("Location: ../purok.php");
$conn->close();
