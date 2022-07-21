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
    
    $userDeatils = [];
    
    $userDetails['name'] = $finalName;
    $userDetails['age'] = $age;
    $userDetails['country'] = $country;
    $userDetails['email'] = $email;
    $userDetails['profile_pic'] = $profilePic;
    

}

  //Database connection
  include 'db_connection.php';


  //Fetching number of users to display
  $sql = "SELECT * FROM users";
  $numberOfUsers = count($conn->query($sql)->fetch_all(MYSQLI_ASSOC));

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
<button  class="ajaxBtn btn" type="">Add user</button>
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


let name = $("#hiddenInputName").val();
let age = $("#hiddenInputAge").val();
let country = $("#hiddenInputCountry").val();
let email = $("#hiddenInputEmail").val();
let profile_pic = $("#hiddenInputPicture").val();

let ob = {
name,
age,
country,
email,
profile_pic

}

ob = JSON.stringify(ob);



//Adding user from api to database
$(".ajaxBtn").click(function(){

    
    let newNumber = parseInt($('#numberOfUsers').text());
    if(newNumber < 10 ){
        newNumber = newNumber +1;
    $('#numberOfUsers').text(newNumber);
    }else{

$('.error').css('display','block');
    }


    $.ajax({
   url: 'saveToDataBase.php',
   data: {data: ob},
//    contentType: "application/json",
   type: 'POST',
   success: function(response) {
      console.log(response);

   }
});

});



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

