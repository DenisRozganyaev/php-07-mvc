<?php Core\View::render('layout/header', ['admin' => true]); ?>
<div class="container">
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="card w-75 mt-5">
                <h5 class="card-header">Update category</h5>
                <div class="card-body">
                    <form action="<?= url("/admin/categories/{$category->id}/update") ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="<?= $category->name ?>" class="form-control" id="name" placeholder="Category name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Description"><?= $category->description ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image" />
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Core\View::render('layout/footer');
