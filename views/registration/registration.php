<?php
if (isset($params['error']) && !empty($params['error'])) {
?>
<main class="m-0">
    <div class="registrationErrorContainer text-center">
        <h1 class="alert-danger"><?= $params['error'] ?></h1>
    </div>

    <?php
    } else {}
    ?>
    <main>
<!--        <div class="registrationInfoContainer text-center">-->
<!---->
<!--            <h1 class="registrationHeader">Register to buy item that's needed or just to find something else</h1>-->
<!--            <p class="registrationText lead">First time visiting our website ? It takes only about a minute, so don't-->
<!--                hesitate and register now !!!!</p>-->
<!--            --><?php //} ?>
<!--        </div>-->

        <div class="registrationFormContainer text-center">
            <form class="registrationForm d-inline-block"
                  action="/clientUser/clientRegistrationResult" method="post">
                <div class="mb-3">
                    <input type="text" name="userName"
                           class="userRegistrationName border form-control" placeholder="name">
                </div>
                <div class="mb-3">
                    <input type="password" name="userPassword"
                           class="userRegistrationPassword border form-control" placeholder="password">
                </div>
                <div class="mb-3">
                    <input type="email" name="userEmail"
                           class="userRegistrationEmail border form-control" placeholder="email">
                </div>
                <div class="mb-3">
                    <input type="tel" name="userPhone"
                           class="userRegistrationPhone border form-control" placeholder="phone">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="userAddress" id="userAddress" cols="10" rows="3" placeholder="Put your address here"></textarea>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="userNotes" id="userNotes" cols="10" rows="3" placeholder="Put your notes here"></textarea>
                </div>

                <div class="mb-3">
                    <input class="btn btn-success" type="submit" name="send" value="Register">
                    <a href="/clientUser/clientLogin" class="btn btn-primary">Login</a>
                </div>
            </form>
        </div>
    </main>