<?php Core\View::render('layout/header'); ?>

<div class="container">
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="card w-50 mt-5">
                <h5 class="card-header">Create an account</h5>
                <div class="card-body">
                    <form action="<?= url('users/store') ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   id="name"
                                   value="<?= !empty($data['name']) ? $data['name'] : '' ?>"
                            >
                            <?php if (!empty($name_error)): ?>
                            <div class="alert alert-danger"><?= $name_error ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">Last Name</label>
                            <input type="text" name="surname" class="form-control" id="surname">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary">Create an account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Core\View::render('layout/footer'); ?>
