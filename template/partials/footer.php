<footer class="text-center fixed-bottom">
    <div class="container p-4 pb-0">
        <section>
            <p class="d-flex justify-content-center align-items-center">
                <?php
                    if (!isset($_COOKIE['client_email']) || empty($_COOKIE['client_email'])) {
                ?>
                <span class="me-3"><a href="/clientUser/clientRegistration" class="register">Register for free</a></span>
                <a href="/clientUser/clientLogin" class="btn btn-outline-light">Sign up</a>
                <?php } else { ?>
                Glad to see you on our website.
                <?php } ?>
            </p>
        </section>
    </div>
    <div class="copyright text-center p-3">
        <i class="fa fa-copyright"></i> 2021 Copyright
    </div>
</footer>


<script src="/jQuery/jquery.cookie.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/template/js/main.js"></script>
</body>
</html>