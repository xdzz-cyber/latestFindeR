<?php
if (isset($params['error']) && !empty($params['error'])) {
?>
<main class="m-0">
    <div class="registrationErrorContainer text-center">
        <h1 class="alert-danger"><?= $params['error'] ?></h1>
    </div>

    <?php
    } else {
    ?>
    <main>
        <div class="registrationInfoContainer text-center">

            <h1 class="registrationHeader">Register to buy item that's needed or just to find something else</h1>
            <p class="registrationText lead">First time visiting our website ? It takes only about a minute, so don't
                hesitate and register now !!!!</p>
            <?php } ?>
        </div>

        <div class="registrationFormContainer text-center">
            <form class="registrationForm d-inline-block"
                  action="/clientUser/clientRegistrationResult" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="email" name="userEmail"
                           class="userRegistrationEmail border form-control form-control-lg" placeholder="email">
                </div>
                <div class="mb-3">
                    <input type="password" name="userPassword"
                           class="userRegistrationPassword border form-control form-control-lg" placeholder="password">
                </div>
                <div class="mb-3">
                    <input type="file" name="userPhoto" class="userRegistrationPhoto form-control form-control-lg">
                </div>
                <div class="mb-3">
                    <input class="btn btn-success btn-lg" type="submit" name="send" value="Register">
                </div>
            </form>
        </div>
    </main>