<section id="header">
    <a href="/"><img src="/image/logo/T-logo-trans.png" class="logo" alt="logo"></a>

    <div>
        <ul id="navbar">
            <li><a <?= $current_page == 'index' ? 'class="active"' : '' ?> href="/">Home</a></li>
            <li><a <?= $current_page == 'inventory' ? 'class="active"' : '' ?> href="cms_inventory.php">Product Management</a></li>
            <li><a <?= $current_page == 'customer' ? 'class="active"' : '' ?> href="cms_customer.php">Customer Management</a></li>
            <li><a <?= $current_page == 'order' ? 'class="active"' : '' ?> href="cms_order.php">Order Management</a></li>
        </ul>
    </div>

</section>