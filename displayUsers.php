<?php

  //Database connection
  include 'db_connection.php';
//Fetching users to display
$sql = "SELECT name,age,country,email,profile_pic FROM users";
$usersForDisplay = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
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
        <style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto ;
  background-color: #2196F3;
  padding: 10px;
}
.grid-item {
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  text-align: center;
}
</style>
<link rel="stylesheet" href="style.css">

	</head>
	<body>
        <?php if(count($usersForDisplay)>0):?>
<h1 style="text-align:center;">USERS</h1>
    <div style="margin-bottom:30px;" class="grid-container">
  <div class="grid-item">name</div>
  <div class="grid-item">age</div>
  <div class="grid-item">country</div>  
  <div class="grid-item">email</div>
  <div class="grid-item">picture</div>
</div>
<?php else:?>
    <h1 style="text-align:center;"> No users in database!</h1>

<?php endif;?>

<?php for($x = 0; count($usersForDisplay) >$x; $x++):?>
<div class="grid-container">
  <div class="grid-item"><?=$usersForDisplay[$x]['name']?></div>
  <div class="grid-item"><?=$usersForDisplay[$x]['age']?></div>
  <div class="grid-item">
    <?=$usersForDisplay[$x]['country']?>
    <br>
    <br>
    <img style="width:30%;" src="<?='https://countryflagsapi.com/png/'. $usersForDisplay[$x]['country'];?>">
    
</div>
  <div class="grid-item"><?=$usersForDisplay[$x]['email']?></div>
  <div class="grid-item"><img src="<?=$usersForDisplay[$x]['profile_pic']?>" alt=""></div>
</div>
<?php endfor;?>

</body>
</html>