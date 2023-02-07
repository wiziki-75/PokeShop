<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/function-pdo.php');

if(!isset($_SESSION['id'])){ header("Location: stop.php");}

function addProduct($name, $price, $img, $user_id, $pdo){
    $sql = "INSERT INTO products (product_name,product_price,product_img,user_id) VALUES (:name,:price,:img,:user_id)";
    $stmt = $pdo->prepare($sql);
    $params = ['name' => $name, 'price' => $price, 'img' => $img, 'user_id' => $user_id];
    $result = $stmt->execute($params);
    return $result;
}

if(isset($_POST['name'])){
  // Validation des entrées
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_SANITIZE_NUMBER_INT);
  $img = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
  if (!$name || !$price || !$img) {
      $_SESSION['error_message'] = "Entrées non valides";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
  }

  // Vérification de l'authentification de l'utilisateur
  if (!isset($_SESSION['id'])) {
      echo '<script>alert("Vous devez être connecté pour ajouter un produit")</script>';
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
  }

  // Ajout du produit
  $res = addProduct($name, $price, $img, $_SESSION['id'], $pdo);
  if($res){
      header('Location: index.php?added=1');
  } else {
      $_SESSION['error_message'] = "An error occurred while adding the product";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
  }
}

?>

<link rel="stylesheet" href="css/style.css">

<div class="container">
    <br>
        <h1>Add a product</h1>
    <form action="add-product.php" method="post">
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input required type="text" class="form-control" name="name" id="exampleInputEmail1" value="" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Price</label>
      <input required type="text" name="price" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Image</label>
      <input required type="text" name="image" class="form-control" id="exampleInputPassword1">
    </div>
  <button type="submit" class="btn btn-primary">Confirm</button>
</form>
</div>