<?php
include('includes/header.php');
include('includes/function-pdo.php');
?>

<link rel="stylesheet" href="css/style.css">

<body>
  <?php

    function addUser($username, $email ,$password ,$pdo){
        $sql = "INSERT INTO users (username,email,password) VALUES (:username,:email,:password)";
        $stmt = $pdo->prepare($sql);
        $params = ['username' => $username, 'email' => $email,'password' => $password];
        $result = $stmt->execute($params);
        return $result;
    }

    function userTest($email,$pdo){
        $sql ="SELECT email FROM users WHERE email = '$email'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    if (isset($_POST['password'])) {
      // Validation des entrées
      $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
      $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
      if (!$username || !$email || !$password) {
          echo '<script>alert("Entrées non valides")</script>';
          exit();
      }
  
      // Vérification de l'unicité de l'email
      $res2 = userTest($email, $pdo);
      if(count($res2) > 0){
          echo '<script>alert("This email is already used by another user")</script>';
      } else {
          // Hachage du mot de passe
          $crypted_password = password_hash($password, PASSWORD_BCRYPT);
          $res = addUser($username, $email, $crypted_password, $pdo);
          if($res){
              header('Location: index.php');
          } else {
              echo '<script>alert("An error occurred while adding the user")</script>';
          }
      }
    }
  ?>

  <div class="container">
  <br>
    <h1>Register</h1>
    <form action="register.php" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input class="form-control" name="username" id="username" aria-describedby="emailHelp">
    </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input required type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input required type="password" name="password" class="form-control" id="password">
      </div>
      <button type="submit" class="btn btn-primary" id="btn">Confirm</button>
    </form>
  </div>


<script>
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$('#btn').on('click', function(event){
  let mail = $('#email').val()
  console.log(mail)
  console.log(validateEmail(mail))
  if(validateEmail(mail) == false){
    event.preventDefault()
    alert("Cette email n'est pas bien formulé !")
  }
})
</script>

</body>
</html>