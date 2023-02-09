<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/function-pdo.php');

function getCart($user_id, $pdo){
  $sql = "SELECT product_id FROM cart WHERE user_id = $user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
  return $result;
}

if(isset($_SESSION['email'])){
  $_SESSION['error_message'] = "You are already logged";
  header("Location: index.php");
}

if (count($_POST) > 0) {
  if (isValid($_POST['email'], $_POST['password'], $pdo)) {
    $_SESSION['email'] = $_POST['email'];

    function getId($email, $pdo){
      $sql = "SELECT user_id,is_admin FROM users WHERE email = '$email'";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    $res2 = getId($_SESSION['email'], $pdo);
    $_SESSION['id'] = $res2[0]['user_id'];
    if($res2[0]['is_admin'] === 1){
      $_SESSION['admin'] = 1;
    }
    $_SESSION['cart'] = count(getCart($_SESSION['id'], $pdo));

    header('Location: index.php');
  } else {
    echo '<script>alert("Login failed")</script>';
  }
}

?>

<body>
    <h1>Login</h1>

    <div class="container">

      <form action="login.php" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input required type="email" class="form-control" name="email" value="" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input required type="password" name="password" value="" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </form><br>
      <div>Not registed ?</div>
      <a class="nav-link" href="register.php"><button type="submit" class="btn btn-primary">Register</button></a>
    </div>
  </body>