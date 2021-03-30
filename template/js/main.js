$(() => {
     const userRegistrationEmail = $(".userRegistrationEmail");
     const userRegistrationPassword = $(".userRegistrationPassword");

     const userLoginEmail = $(".userLoginEmail");
     const userLoginPassword = $(".userLoginPassword");

     const loginForm = $(".loginForm");
     const registrationForm = $(".registrationForm");


    class formValidation {
        #email_filter = /\S+@\S+\.\S+/ig;
        #email = userRegistrationEmail.parent().length ? userRegistrationEmail : userLoginEmail;
        #password = userRegistrationPassword.parent().length ? userRegistrationPassword : userLoginPassword;

        getEmail(){
            return this.#email;
        }

        getPassword(){
            return this.#password;
        }

        emailValidation() {

            if (!this.#email.val().match(this.#email_filter) || !this.#email.val()) {
                console.log("Email is NOT valid and value is " + this.#email.val());
                this.#email.removeClass("border-success");
                this.#email.addClass("border-warning");
                return false;
            }
            console.log("Email is valid and value is " + this.#email.val());
            this.#email.removeClass("border-warning");
            this.#email.addClass("border-success");
            return true;

        }

        passwordValidation() {

            if (!this.#password.val()) {
                this.#password.removeClass("border-success");
                this.#password.addClass("border-warning");
                return false;
            }
            this.#password.removeClass("border-warning");
            this.#password.addClass("border-success");
            return true;

        }
    }

    class makeSliderPrice{
        #minPrice = 0;
        #maxPrice = 400;

        makeSlider(){
            $("#slider-range").slider({
               range: true,
               min: this.#minPrice,
               max: this.#maxPrice,
               values: [50,250],
                slide(event,ui){
                   $(".minPrice").val(ui.values[0]);
                   $(".maxPrice").val(ui.values[1]);
                }
            });

        }
    }


    function changeMarginIfDanger(){
        if($(".alert-danger").text()){
            $(".registrationInfoContainer").removeClass("my-md-4");
            $(".loginInfoContainer").removeClass("my-md-4");
        }
    }



    function preventEnterForm(){
        let form = loginForm.parent().length ? loginForm : registrationForm;
        form.submit(e => {
           if (!validationObject.emailValidation()){
               e.preventDefault()
           }

           if (!validationObject.passwordValidation()){
               e.preventDefault();
           }
        });
    }


    changeMarginIfDanger();

    let validationObject = new formValidation();

    let makeSliderPriceObject = new makeSliderPrice();
    makeSliderPriceObject.makeSlider();

    validationObject.getEmail().keyup(e => validationObject.emailValidation());

    validationObject.getPassword().keyup(e => validationObject.passwordValidation());

    preventEnterForm();
});