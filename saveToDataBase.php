<?php


if(isset($_POST['data'])){
$data = $_POST['data'];
$data = json_decode($data,true);

$name = $data['name'];
$age = $data['age'];
$country = $data['country'];
$email = $data['email'];
$profile_pic = $data['profile_pic'];

include 'db_connection.php';


//Sanitizing inputs

$name = filter_var($name, FILTER_SANITIZE_STRING);
$name = mysqli_real_escape_string($conn, $name);

$age = filter_var($age, FILTER_SANITIZE_STRING);
$age = mysqli_real_escape_string($conn, $age);
$age = intval($age);


$country = filter_var($country, FILTER_SANITIZE_STRING);
$country = mysqli_real_escape_string($conn, $country);

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = mysqli_real_escape_string($conn, $email);

$profile_pic = filter_var($profile_pic, FILTER_SANITIZE_STRING);
$profile_pic = mysqli_real_escape_string($conn, $profile_pic);




//Insert into database!

$sql2 = "SELECT * FROM users";
$result2 = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);



//Limits up to 10 users in database

if(count($result2) < 10){

    $sql = "INSERT INTO `users`( `name`, `age`, `country`, `email`, `profile_pic`) VALUES ('$name', '$age','$country', '$email','$profile_pic');";
    $result = $conn->query($sql);
    
    if($result){
        echo  "Insetion of data is successful!";
    }else{

        echo 'Insetion of data failed!';
    };
    
    
   



}else if(count($result2) >=10){
    //Updates the first user row in database
    $sql = "UPDATE `users` SET `name`='$name',`age`='$age',`country`='$country',`email`='$email',`profile_pic`= '$profile_pic' WHERE id = 1";
// $result = $conn->query($sql);
$result = mysqli_query($conn,$sql);

if($result){
var_dump(count($result2));
    echo  'updating of data is successful!';
}else{
    echo 'updating of data failed!';
};

}


mysqli_close($conn);

}