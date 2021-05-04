<main>
    <div class="restorePasswordPageHeaderContainer text-center">
        <h1><?=$params['info']?></h1>
    </div>

    <form action="/clientUser/restorePassword/<?=$params['user_id']?>" method="post" class="restorePasswordPageForm text-center">
        <div class="mb-4">
            <label for="newPassword" class="form-label fw-bold fs-2 mb-3">New password</label>
            <input required type="password" class="newPasswordInput form-control w-25 form-control-lg mx-auto" name="newPassword"  id="newPassword" aria-describedby="newPasswordHelp" placeholder="Enter you new password here">
        </div>
        <div class="mb-4">
            <label for="newPasswordRepeat" class="form-label fw-bold fs-2 mb-3">New password repeat</label>
            <input required type="password" class="newPasswordRepeatInput form-control w-25 form-control-lg mx-auto" name="newPasswordRepeat"  id="newPasswordRepeat" aria-describedby="newPasswordRepeatHelp" placeholder="Repeat you new password here">
        </div>
        <button type="submit" name="send" class="btn btn-primary btn-lg">Submit</button>
    </form>
</main>