<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Pokebif <?php if(isset($_SESSION['admin'])){ echo "(admin)"; } ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                            <li class="nav-item active">
                                <a <?php if(!isset($_SESSION['email'])){ echo 'hidden'; } ?> class="nav-link" href="add-product.php">Add a product <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a <?php if(isset($_SESSION['email'])){ echo 'hidden'; } ?> class="nav-link" href="register.php">Register</a>
                            </li>
                            <li class="nav-item">
                                <a <?php if(isset($_SESSION['email'])){ echo 'hidden'; } ?> class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a <?php if(!isset($_SESSION['email'])){ echo 'hidden'; } ?> class="nav-link" href="account.php">Account</a>
                            </li>
                            <li class="nav-item">
                                <a <?php if(!isset($_SESSION['email'])){ echo 'hidden'; } ?> class="nav-link" href="logout.php">Logout</a>
                            </li>
                    </ul>
                    <?php
                        if(isset($_SESSION['email'])){
                    ?>
                    <form class="d-flex" action="cart.php">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1" ></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?= $_SESSION['cart'] ?></span>
                        </button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </nav>