<main>
    <form action="/clientUser/checkForgetUserPasswordResult" method="post" class="forgetPasswordForm text-center">
        <div class="mb-4">
            <label for="forgetPasswordUserEmail" class="form-label fw-bold fs-2 mb-3">Email address</label>
            <input required type="email" class="forgetUserPasswordEmailInput form-control form-control-lg mx-auto" name="userEmail"  id="forgetPasswordUserEmail" aria-describedby="emailHelp" placeholder="Enter you email here">
        </div>
        <button type="submit" name="send" class="btn btn-primary btn-lg">Submit</button>
    </form>
</main>