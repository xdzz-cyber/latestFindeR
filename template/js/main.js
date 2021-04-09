$(() => {

     const userRegistrationEmail = $(".userRegistrationEmail");
     const userRegistrationPassword = $(".userRegistrationPassword");

     const userLoginEmail = $(".userLoginEmail");
     const userLoginPassword = $(".userLoginPassword");

     const loginForm = $(".loginForm");
     const registrationForm = $(".registrationForm");


    class formValidation {
        email_filter = /\S+@\S+\.\S+/ig;
        email = userRegistrationEmail.parent().length ? userRegistrationEmail : userLoginEmail;
        password = userRegistrationPassword.parent().length ? userRegistrationPassword : userLoginPassword;

        getEmail(){
            return this.email;
        }

        getPassword(){
            return this.password;
        }

        emailValidation() {

            if (!this.email.val().match(this.email_filter) || !this.email.val()) {
                console.log("Email is NOT valid and value is " + this.email.val());
                this.email.removeClass("border-success");
                this.email.addClass("border-warning");
                return false;
            }
            console.log("Email is valid and value is " + this.email.val());
            this.email.removeClass("border-warning");
            this.email.addClass("border-success");
            return true;

        }

        passwordValidation() {

            if (!this.password.val()) {
                this.password.removeClass("border-success");
                this.password.addClass("border-warning");
                return false;
            }
            this.password.removeClass("border-warning");
            this.password.addClass("border-success");
            return true;

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

    function banSearchIfNotLogIn(){
        if (!$.cookie("client_email")){
            $(".searchItemsInput").prop("disabled", true);
        }
    }

    function checkInputValueToSetCookie(){
        $(".searchItemsInput").keyup(e => {
            let searchName = $(e.target).val();
           if (searchName){
               $.cookie("client_search_name",searchName,{path: "/"});
               console.log("addCookie")
           } else{
               $.removeCookie("client_search_name", {path: "/"});
               console.log("removeCookie")
           }
        });
    }

    function setSearchNameInputValue(){
         let searchName = $.cookie("client_search_name") ?? "";
         $(".searchItemsInput").val(searchName);
    }

    function submitFiltersFormOnButton(){
        $(".findByFilters").click(e => {
           $(".findByFiltersForm").submit();
        });
    }


     async function getMaxMinPriceFromDB(){
        // $.post("http://mvcShopLatest/template/gettingAsyncData/getMaxMinPrice.php", {}, function (data,textStatus){
        //     return data;
        // }, "json");

        let response =  await fetch("http://mvcShopLatest/template/gettingAsyncData/getMaxMinPrice.php");
        return await response.json();
    }

    async function makeSlider(){
        const maxMinPriceObject = await getMaxMinPriceFromDB();
        let {maxPrice, minPrice} = maxMinPriceObject[0];
        maxPrice = parseInt(maxPrice, 10);
        minPrice = parseInt(minPrice, 10);

        $("#slider-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice],
            slide(event,ui){
                $(".minPrice").val(ui.values[0]);
                $(".maxPrice").val(ui.values[1]);
            }
        });
    }

    submitFiltersFormOnButton();

    checkInputValueToSetCookie();

    setSearchNameInputValue();

    banSearchIfNotLogIn();

    changeMarginIfDanger();

    makeSlider();

    let validationObject = new formValidation();

    validationObject.getEmail().keyup(e => validationObject.emailValidation());

    validationObject.getPassword().keyup(e => validationObject.passwordValidation());

    preventEnterForm();
});