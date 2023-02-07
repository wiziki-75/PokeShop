<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/function-pdo.php');
include('includes/function.php');

if(isset($_GET['refresh'])){
    header("Refresh:0; url=index.php" );
}

$sort = 0;
$search = '';

if(isset($_POST['sort'])){
    $sort = $_POST['sort'];
}

if(isset($_POST['search'])){
    $search = $_POST['search'];
    $sort = 5;
}

$products = getProducts($search, $sort, $pdo);

if(isset($_GET['user_id'], $_GET['product_id'])){
    addCart($_GET['user_id'], $_GET['product_id'], $pdo);
    header("Refresh:0; url=index.php?toCart=1" );
}

if(isset($_SESSION['email'])){
    $_SESSION['cart'] = count(getCart($_SESSION['id'], $pdo));
}

if(isset($_GET['delete'])){
    deleteProduct($_GET['delete'], $pdo);
    header("Refresh:0; url=index.php?deleted=1" );
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Section-->
        <section class="py-5">
            <form action="index.php" method="POST">
                <select name="sort" id="f">
                    <option value="">Choose option</option>
                    <option value="1">By name A - Z</option>
                    <option value="2">By name Z - A</option>
                    <option value="3">By price ASC</option>
                    <option value="4">By price DESC</option>
                </select>
                <button type="submit" class="btn btn-primary">Sort</button>
            </form>
            <form action="index.php" method="post">
                <label for="search">By name</label>
                <input type="text" name="search">
                <button type="submit" class="btn btn-primary">Search</button>
            </form><br>

            <a class="nav-link" href="index.php?refresh=1">Reset</a>

            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                    <?php
                        if(empty($products)){
                            echo 'Product not found';
                        }
                        for($i = 0; $i < count($products);$i++){
                    ?>

                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?= $products[$i]['product_img']?>" alt="..." width="450px" height="300px" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><a href="detail.php?id=<?= $products[$i]['product_id'] ?>"><?= $products[$i]['product_name'] ?></a></h5>
                                    <!-- Product price-->
                                    <?= $products[$i]['product_price'] ?>€<br>
                                    <?= $products[$i ]['date'] ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto" 
                                        href="<?php if(isset($_SESSION['id'])){ echo "index.php?user_id=";} else { echo "stop.php";}
                                        if(isset($_SESSION['id'])){ echo $_SESSION['id'] ?>&product_id=<?php echo $products[$i]['product_id']; }?>">
                                        Add to cart
                                    </a>
                                    <?php if(isset($_SESSION['admin'])) { ?>
                                    <a class="btn btn-outline-dark mt-auto" href="index.php?delete=<?= $products[$i]['product_id'] ?>">
                                        Delete
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                    
                </div>
            </div>
        </section>

        <!-- Toast elements -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="deletedElement" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <img src="assets/pokeball.png" width="20" height="20" class="rounded me-2" alt="...">
                <strong class="me-auto">Pokebif</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Product deleted.
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="addedElement" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <img src="assets/pokeball.png" width="20" height="20" class="rounded me-2" alt="...">
                <strong class="me-auto">Pokebif</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Product added.
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toCartElement" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <img src="assets/pokeball.png" width="20" height="20" class="rounded me-2" alt="...">
                <strong class="me-auto">Pokebif</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Product added to cart.
                </div>
            </div>
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Pokebif</p></div>
            <div class="container"><p class="m-0 text-center text-white"> 07 23 88 21 35</p></div>
            <div class="container"><p class="m-0 text-center text-white"> contact@poke.bif</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <?php
            if(isset($_GET['deleted'])){
                print(
                    "<script>
                        const toastLiveExample = document.getElementById('deletedElement')
                        const toast = new bootstrap.Toast(toastLiveExample)
                        toast.show()
                        console.log('toast')
                    </script>"
                );
            }

            if(isset($_GET['added'])){
                print(
                    "<script>
                        const toastLiveExample = document.getElementById('addedElement')
                        const toast = new bootstrap.Toast(toastLiveExample)
                        toast.show()
                        console.log('toast')
                    </script>"
                );
            }

            if(isset($_GET['toCart'])){
                print(
                    "<script>
                        const toastLiveExample = document.getElementById('toCartElement')
                        const toast = new bootstrap.Toast(toastLiveExample)
                        toast.show()
                        console.log('toast')
                    </script>"
                );
            }
        ?>
    </body>
</html>
