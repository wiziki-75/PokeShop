<?php

function isValid($email, $password, $pdo){

    $sql = "SELECT email,password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        if (password_verify($password, $result[0]['password'])) {
            return true;
        }
    }

    return false;
}

?>