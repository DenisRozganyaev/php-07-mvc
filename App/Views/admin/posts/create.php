<?php Core\View::render('layout/header', ['admin' => true]); ?>
<div class="container">
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="card w-50 mt-5">
                <h5 class="card-header">Create new post</h5>
                <div class="card-body">
                    <form action="<?= url('/auth/posts/store') ?>" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Core\View::render('layout/footer');
