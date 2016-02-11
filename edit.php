<?php include('config.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Login to puppyCMS</title>
</head>
<body>
<xmp theme="<?php echo $theme; ?>"  style="display:none;">
<?php
  
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == $username
&& $pass == $password)
{
        header('Location: '.'/content/'.$editor_file);
}
else
{
    if(isset($_POST))
    {?>

<form method="POST" action="edit.php">
User <input type="text" name="user"></input><br/>
Pass <input type="password" name="pass"></input><br/>
<input type="submit" name="submit" value="Login"></input>
</form>
    <?}
}
?>
</xmp>
<script src="<?php echo $strapdown_location; ?>"></script>
</body>
</html>