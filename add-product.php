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

  $target_dir = "img/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  if (!$name || !$price || $uploadOk != 1) {
    if($uploadOk != 1){
      $_SESSION['error_message'] = "File upload failed, please check image size and image extension.";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      $_SESSION['error_message'] = "Input not valide, check name and price.";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } else {
      // Vérification de l'authentification de l'utilisateur
      if (!isset($_SESSION['id'])) {
        echo '<script>alert("Vous devez être connecté pour ajouter un produit")</script>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
      }

      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }

      // Ajout du produit
      $res = addProduct($name, $price, $target_file, $_SESSION['id'], $pdo);
      if($res){
        header('Location: index.php?added=1');
      } else {
        $_SESSION['error_message'] = "An error occurred while adding the product";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
      }
  }
}

?>

<link rel="stylesheet" href="css/style.css">

<div class="container">
    <br>
        <h1>Add a product</h1>
    <form action="add-product.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input required type="text" class="form-control" name="name" id="exampleInputEmail1" value="" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Price</label>
        <input required type="text" name="price" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Image (Size must be less than 5MB)</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
      </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
</div>