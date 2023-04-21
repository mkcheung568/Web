<section id="header">
    <a href="/"><img src="/image/logo/T-logo-trans.png" class="logo" alt="logo"></a>

    <div>
        <ul id="navbar">
            <li><a <?=$current_page == 'index' ? 'class="active"' : '' ?>   href="index.php">Home</a></li>
            <li><a <?=$current_page == 'shop' ? 'class="active"' : '' ?>    href="shop.php">Shop</a></li>
            <li><a <?=$current_page == 'about' ? 'class="active"' : '' ?>   href="about.php">About</a></li>
            <li><a <?=$current_page == 'contact' ? 'class="active"' : '' ?> href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])) { ?><li><a <?=$current_page == 'order' ? 'class="active"' : '' ?> href="order.php">View Orders</a></li> <?php } ?>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?><li><a href="cms_inventory.php">CMS</a></li> <?php } ?>
            <?php if (!isset($_SESSION['user_id'])) { ?><li><a <?=$current_page == 'login' ? 'class="active"' : '' ?> href="login.php">Login</a></li> <?php } ?>
            <?php if (isset($_SESSION['user_id'])) { ?><li><a href="logout.php">Logout</a></li> <?php } ?>
            <li id="lg-bag"><a <?=$current_page == 'cart' ? 'class="active"' : '' ?> href="cart.php"><i class="fa-sharp fa-solid fa-cart-arrow-down"></i></a></li>
            <a href="#" id="close"><i class="fa-solid fa-times"></i></a>
        </ul>
    </div>

    <div id="mobile">
        <a href="cart.php"><i class="fa-sharp fa-solid fa-cart-arrow-down"></i></a>
        <i id="bar" class="fa-solid fa-outdent"></i>
    </div>

</section>