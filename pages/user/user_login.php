<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['user_id']){
  echo "<script>
            window.location.href = '/IP2-PROJECT/pages/user/reports.php';
        </script>";
        exit;

}
else{
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Login</title>
  <link rel="icon" href="../../assets/images/favicon (1).ico">
  <link rel="stylesheet" href="../../assets/css/login.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />     
  <script src="../../assets/javascript/javascript.js"></script>

</head>

<body id="log-in">
  
  <main>
    
    <div class="x-icon"><a href="../../index.html"><b><i class="fa-solid fa-x"></i></b></a></div>

    <form action="http://localhost/IP2-PROJECT/assets/backend/controllers/UserLoginController.php" method="post" id ="login-form">
      <fieldset>
        <legend>Client Login</legend>

        <input type="text" id="username" name="username" placeholder="Username" required><br>
        <input type="password" id="password" name="password" placeholder="Password"  required><br>
        <button type="submit">Login</button>
      </fieldset>

      <p class="forget"><a href="#">Forget password?</a></p>
    </form>

  </main>
  <footer>
    <p class="copyright">&copy; 2024 All Rights Reserved.</p>
  </footer> 

</body>

</html>
<?php }?>