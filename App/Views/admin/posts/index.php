<?php Core\View::render('layout/header', ['admin' => true]); ?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center text-uppercase">
            <?php
            if (!empty($posts)) {
                include_once VIEW_DIR . '/admin/posts/parts/products_list.php';
            } else {
                echo "<h3>There are no posts yet</h3>";
            }
            ?>
        </div>
    </div>
</div>
<?php
Core\View::render('layout/footer');
