<div class="container">
    <div class="row pt-5">
        <div class="col-md-6 offset-3">
            <form method="post" action="<?= baseUrl('/store') ?>">
                <h1 class="h3 mb-3 fw-normal text-center">Registration</h1>
                <div class="form-floating mb-3">
                    <input
                            type="text"
                            class="form-control <?= getValidationClass('name'); ?>"
                            id="name"
                            placeholder="Name"
                            name="name"
                            value="<?= old('name') ?>"
                    />
                    <label for="name">Name</label>

                    <?= getErrors('name') ?>
                </div>

                <div class="form-floating mb-3">
                    <input
                            name="email"
                            type="email"
                            class="form-control <?= getValidationClass('email'); ?>"
                            id="floatingInput"
                            placeholder="name@example.com"
                            value="<?= old('email') ?>"
                    />
                    <label for="floatingInput">Email address</label>
                    <?= getErrors('email') ?>
                </div>

                <div class="form-floating mb-3">
                    <input
                            name="password"
                            type="password"
                            class="form-control <?= getValidationClass('password'); ?>"
                            id="floatingPassword"
                            placeholder="Password"
                    />
                    <label for="floatingPassword">Password</label>
                    <?= getErrors('password') ?>
                </div>

                <div class="form-floating mb-3">
                    <input
                            name="confirmPassword"
                            type="password"
                            class="form-control <?= getValidationClass('confirmPassword'); ?>"
                            id="confirmPassword"
                            placeholder="Confirm password"
                    />
                    <label for="confirmPassword">Confirm password</label>
                    <?= getErrors('confirmPassword') ?>
                </div>

                <?= getCsrfField() ?>

                <button class="btn btn-primary w-100 py-2" type="submit">
                    Register
                </button>
            </form>

            <?php
            session()->remove('formData');
            session()->remove('formErrors');
            ?>
        </div>
    </div>
</div>