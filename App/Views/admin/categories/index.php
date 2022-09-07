<?php Core\View::render('layout/header', ['admin' => true]); ?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center text-uppercase">
            <?php
            if (!empty($categories)) {
                include_once VIEW_DIR . '/admin/categories/parts/categories_list.php';
            } else {
                echo "<h3>There are no categories yet</h3>";
            }
            ?>
        </div>
    </div>
</div>
<?php
Core\View::render('layout/footer');
