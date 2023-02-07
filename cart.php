<?php

include('includes/function-pdo.php');
include('includes/header.php');
include('includes/navbar.php');

function getProductsById($product_id, $pdo){
    $sql = "SELECT product_id,product_name,product_price,product_img,user_id FROM products WHERE product_id = $product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getCart($user_id, $pdo){
    $sql = "SELECT product_id,cart_id FROM cart WHERE user_id = $user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function deleteCartElement($cart_id, $pdo){
    $sql = "DELETE FROM cart WHERE cart_id = :cart_id";
    $stmt = $pdo->prepare($sql);
    $params = ['cart_id' => $cart_id];
    $result = $stmt->execute($params);
    return $result;
}

$product_id = getCart($_SESSION['id'], $pdo);

if(isset($_GET['delete'])){
    deleteCartElement($_GET['delete'], $pdo);
    $cart = getCart($_SESSION['id'], $pdo);
    $_SESSION['cart'] = count($cart);
    header("Refresh:0; url=cart.php");
}

$cartValue = 0;

for($i = 0; $i < count($product_id); $i++){
    $product = getProductsById($product_id[$i]['product_id'], $pdo);

    $cartValue += $product[0]['product_price'];
?>

<ul class="list-group list-group-horizontal cart">
    <li class="list-group-item"><?= $product[0]['product_name'] ?></li>
    <li class="list-group-item"><?= $product[0]['product_price'] ?></li>
    <li class="list-group-item"><a class="nav-link" href="cart.php?delete=<?= $product_id[$i]['cart_id'] ?>"><button type="submit" class="btn btn-primary">Delete</button></a></li>
</ul>

<?php } ?>

<ul class="list-group list-group-horizontal cart">
    <li class="list-group-item">TOTAL</li>
    <li class="list-group-item"><?= $cartValue ?></li>
</ul>

<a type="button" class="btn btn-outline-success" href="#">Checkout</a>
