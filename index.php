<?php 



echo '<pre>';
// From URL to get webpage contents.
$url = "https://randomuser.me/api/";
 
// Initialize a CURL session.
$ch = curl_init();
 
// Return Page contents.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
//grab URL and pass it to the variable.
curl_setopt($ch, CURLOPT_URL, $url);

$result = curl_exec($ch);
if(!($result)){
    echo '<div style=
    "text-align: center;
    font-size: 20px;
    color: red;
    font-weight: 600;
    border: 3px solid black;
    margin: auto;
    width: 27%;
    height: 50px;
    padding-top: 20px;">API called failed!</div>';
die();
}else{

  //Database connection
  include 'db_connection.php';

    $result = json_decode($result,true);

    $nameArr = $result['results'][0]['name'];
    $finalName = '';   
    foreach($nameArr as $r){
        
        $finalName .= $r .' ';
    }
    
    
    //Name aquired!
    // echo $finalName;
    
    //Age aquired!
    $age = $result['results'][0]["dob"]['age'];
    
    //Country aquired!
    $country = $result['results'][0]['location']['country'];
    
    //Email aquired!
    $email = $result['results'][0]['email'];
    
    //Profile picture aquired!
    $profilePic = $result['results'][0]['picture']['large'];
    

    
    if(isset($_POST['ajaxBtn'])){

        $finalName = filter_var($finalName, FILTER_SANITIZE_STRING);
        $finalName = mysqli_real_escape_string($conn, $finalName);
        
        $age = filter_var($age, FILTER_SANITIZE_STRING);
        $age = mysqli_real_escape_string($conn, $age);
        $age = intval($age);
        
        
        $country = filter_var($country, FILTER_SANITIZE_STRING);
        $country = mysqli_real_escape_string($conn, $country);
        
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($conn, $email);
        
        $profilePic = filter_var($profilePic, FILTER_SANITIZE_STRING);
        $profilePic = mysqli_real_escape_string($conn, $profilePic);
            
        //Insert into database!
        
        $sql2 = "SELECT * FROM users";
        $result2 = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);
        
        //Limits up to 10 users in database
        
        if(count($result2) < 10){
        
            $sql = "INSERT INTO `users`( `name`, `age`, `country`, `email`, `profile_pic`) VALUES ('$finalName', '$age','$country', '$email','$profilePic');";
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
            echo  'updating of data is successful!';
        }else{
            echo 'updating of data failed!';
        };
        
        }
    }
}




  //Fetching number of users to display
  $sql = "SELECT * FROM users";
  $numberOfUsers = count($conn->query($sql)->fetch_all(MYSQLI_ASSOC));
// var_dump($conn);
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="style.css">


	</head>
	<body>


<input id="hiddenInputName" type="hidden" value="<?php echo $userDetails['name'];?>">
<input id="hiddenInputAge" type="hidden" value="<?php echo $userDetails['age'];?>">
<input id="hiddenInputCountry" type="hidden" value="<?php echo $userDetails['country'];?>">
<input id="hiddenInputEmail" type="hidden" value="<?php echo $userDetails['email'];?>">
<input id="hiddenInputPicture" type="hidden" value="<?php echo $userDetails['profile_pic'];?>">


<?php if($result):?>
<div class="biggerBox">

    <div style="display:flex;justify-content:center;"> 
    <div class="desc">number of users:</div>
    <div id="numberOfUsers" class="desc"><?=(($numberOfUsers));?></div>
</div>
<form method="POST">
<button type="submit" name="ajaxBtn"  class="ajaxBtn btn" type="">Add user</button>


</form>
<button class="ajaxDeleteUsers btn" type="">Delete all users</button>
<span style="
justify-content:center;
display:flex;
font-size:20px;
font-weight:600;
"><a href="http://localhost/phpnewtest/displayUsers.php">List of user from database page</a></span>
<span class="error">Cannot add more then 10 users!</span>
    <?php endif;?>

</div>
    </body>
    <script>
//Deleting all users from database
$(".ajaxDeleteUsers").click(function(){
    $('.error').css('display','none');

    let newNumber = parseInt($('#numberOfUsers').text());
        newNumber = 0;
    $('#numberOfUsers').text(newNumber);

    $.ajax({
   url: 'deleteAllUsers.php',
   type: 'POST',
   success: function(response) {
      console.log(response);

   }
});

});


        </script>
</html>

