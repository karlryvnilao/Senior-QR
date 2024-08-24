<?php 
include '../server/server.php';

if(!isset($_SESSION['username'])){
    header("Location: " . ($_SERVER["HTTP_REFERER"] ?? '../index.php'));
    exit();
}

$id = $conn->real_escape_string($_POST['id']);
$national_id = $conn->real_escape_string($_POST['national']);
$fname = $conn->real_escape_string($_POST['fname']);
$mname = $conn->real_escape_string($_POST['mname']);
$lname = $conn->real_escape_string($_POST['lname']);
$bplace = $conn->real_escape_string($_POST['bplace']);
$bdate = $conn->real_escape_string($_POST['bdate']);
$age = $conn->real_escape_string($_POST['age']);
$cstatus = $conn->real_escape_string($_POST['cstatus']);
$gender = $conn->real_escape_string($_POST['gender']);
$purok = $conn->real_escape_string($_POST['purok']);
$email = $conn->real_escape_string($_POST['email']);
$number = $conn->real_escape_string($_POST['number']);
$address = $conn->real_escape_string($_POST['address']);
$occu = $conn->real_escape_string($_POST['occupation']);
$citi = $conn->real_escape_string($_POST['citizenship']);
$deceased = $conn->real_escape_string($_POST['deceased']);
$pension = $conn->real_escape_string($_POST['pension']);
$remarks = $conn->real_escape_string($_POST['remarks']);
$profile = $conn->real_escape_string($_POST['profileimg']);
$profile2 = $_FILES['img']['name'];

$newName = date('dmYHis') . str_replace(" ", "", $profile2);
$target = "../assets/uploads/resident_profile/" . basename($newName);

$check = "SELECT id FROM tblresident WHERE national_id='$national_id'";
$nat = $conn->query($check)->fetch_assoc();

if ($nat['id'] == $id || count($nat) <= 0) {
    if (!empty($id)) {
        $updateFields = "national_id='$national_id', citizenship='$citi', firstname='$fname', middlename='$mname', lastname='$lname',
                        birthplace='$bplace', birthdate='$bdate', age=$age, civilstatus='$cstatus', gender='$gender', 
                        purok='$purok', phone='$number',
                        email='$email', occupation='$occu', address='$address', deceased='$deceased', 
                        pension='$pension', remarks='$remarks'";

        if (!empty($profile)) {
            $updateFields .= ", picture='$profile'";
        } else if (!empty($profile2)) {
            $updateFields .= ", picture='$newName'";
        }

        $query = "UPDATE tblresident SET $updateFields WHERE id=$id";

        if ($conn->query($query) === true) {
            if (!empty($profile2) && move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
                $_SESSION['message'] = 'Resident Information has been updated!';
                $_SESSION['success'] = 'success';
            } else {
                $_SESSION['message'] = 'Resident Information has been updated but image upload failed!';
                $_SESSION['success'] = 'warning';
            }
        } else {
            $_SESSION['message'] = 'Error updating resident information: ' . $conn->error;
            $_SESSION['success'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'Please complete the form!';
        $_SESSION['success'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'National ID is already taken. Please enter a unique national ID!';
    $_SESSION['success'] = 'danger';
}

header("Location: ../resident.php");
$conn->close();
?>
