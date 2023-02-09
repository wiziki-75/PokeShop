<?php

function getProductsById($product_id, $pdo){
    $sql = "SELECT product_id,product_name,product_price,product_img,user_id FROM products WHERE product_id = $product_id";
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

 function getProducts($search, $sort, $pdo){    
    switch($sort){
        case 1:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products ORDER BY product_name";
            break;
        case 2:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products ORDER BY product_name DESC";
            break;
        case 3:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products ORDER BY product_price";
            break;
        case 4:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products ORDER BY product_price DESC";
            break;
        case 5:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products WHERE product_name LIKE '$search%' ORDER BY product_price";
            break;
        default:
            $sql = "SELECT product_id,product_name,product_price,product_img,user_id,date FROM products";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getCart($user_id, $pdo){
    $sql = "SELECT product_id FROM cart WHERE user_id = $user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function addCart($user_id, $product_id, $pdo){
    $sql = "INSERT INTO cart (user_id, product_id) VALUES (:user_id,:product_id)";
    $stmt = $pdo->prepare($sql);
    $params = ['user_id' => $user_id, 'product_id' => $product_id];
    $result = $stmt->execute($params);
    return $result;
}

function deleteProduct($product_id, $file, $pdo){
    unlink($file);
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $params = ['product_id' => $product_id];
    $result = $stmt->execute($params);
    return $result;
}

function deleteItemInCart($user_id, $product_id, $pdo){
    $sql = "DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $params = ['product_id' => $product_id, 'user_id' => $user_id];
    $result = $stmt->execute($params);
    return $result;
}

?>