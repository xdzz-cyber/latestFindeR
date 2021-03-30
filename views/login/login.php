<main>

    <div class="loginInfoContainer text-center my-md-4">
        <?php
        if (isset($params['error']) && !empty($params['error'])){
        ?>
        <h1 class="alert-danger"><?= $params['error'] ?></h1>
        <?php } else {?>
        <h1>Login here if you have an existing account</h1>
        <p class="lead">Please, be sure to fill all blanks with correct credentials, otherwise we won't be able to give you access to our shop</p>
        <?php } ?>
    </div>

    <div class="loginFormContainer text-center">
        <form class="loginForm d-inline-block" method="post" action="/clientUser/clientLoginResult">
            <div class="mb-3">
                <input type="email" name="userEmail" class="userLoginEmail form-control form-control-lg" placeholder="email">
            </div>
            <div class="mb-3">
                <input type="password" name="userPassword" class="userLoginPassword form-control form-control-lg" placeholder="password">
            </div>
            <div class="mb-3">
                <input type="submit" name="send" value="Sign up" class="btn btn-success btn-lg">
            </div>
        </form>
    </div>
</main>