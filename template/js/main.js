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

        getEmail() {
            return this.email;
        }

        getPassword() {
            return this.password;
        }

        emailValidation() {

            if (!this.email.val().match(this.email_filter) || !this.email.val()) {
                this.email.removeClass("border-success");
                this.email.addClass("border-warning");
                return false;
            }
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


    function changeMarginIfDanger() {
        if ($(".alert-danger").text()) {
            $(".registrationInfoContainer").removeClass("my-md-4");
            $(".loginInfoContainer").removeClass("my-md-4");
        }
    }


    function preventEnterForm() {
        let form = loginForm.parent().length ? loginForm : registrationForm;
        form.submit(e => {
            if (!validationObject.emailValidation()) {
                e.preventDefault()
            }

            if (!validationObject.passwordValidation()) {
                e.preventDefault();
            }
        });
    }

    function banSearchIfNotLogIn() {
        if (!$.cookie("client_email")) {
            $(".searchItemsInput").prop("disabled", true);
        }
    }

    function checkInputValueToSetCookie() {
        $(".searchItemsInput").keyup(e => {
            let searchName = $(e.target).val();
            if (searchName) {
                $.cookie("client_search_name", searchName, {path: "/"});
                console.log("addCookie")
            } else {
                $.removeCookie("client_search_name", {path: "/"});
                console.log("removeCookie")
            }
        });
    }

    function setSearchNameInputValue() {
        let searchName = $.cookie("client_search_name") ?? "";
        $(".searchItemsInput").val(searchName);
    }

    function submitFiltersFormOnButton() {
        $(".findByFilters").click(e => {
            $(".findByFiltersForm").submit();
        });
    }


    async function getMaxMinPriceFromDB() {
        // $.post("http://mvcShopLatest/template/gettingAsyncData/getMaxMinPrice.php", {}, function (data,textStatus){
        //     return data;
        // }, "json");

        let response = await fetch("http://mvcShopLatest/template/gettingAsyncData/getMaxMinPrice.php");
        return await response.json();
    }

    async function makeSlider() {
        const maxMinPriceObject = await getMaxMinPriceFromDB();
        let {maxPrice, minPrice} = maxMinPriceObject[0];
        maxPrice = parseInt(maxPrice, 10);
        minPrice = parseInt(minPrice, 10);

        $("#slider-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice],
            slide(event, ui) {
                $(".minPrice").val(ui.values[0]);
                $(".maxPrice").val(ui.values[1]);
            }
        });
    }

    function activateSearchBar(){
        $(".openSearchElement").click(e => {
            e.preventDefault();
           $(".mainHeaderNavbarNav").hide();
           $(".searchFormContainer").toggleClass("d-none");
        });
    }

    function closeSearchBar(){
        $(".closeSearchElement").click(e => {
            e.preventDefault();
            $(".searchFormContainer").toggleClass("d-none");
            $(".mainHeaderNavbarNav").show();
        })
    }

    async function getBasketItemsCount(){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsCount.php");
        let json_data = await rawData.json();
        $(".fa-shopping-basket").append(json_data.count);
        localStorage.setItem("basketItemsCount", json_data.count);
    }

    function showBasketPageIfNotEmpty(){

        $(".basketItemsPageLink").click(e => {
            let basketItemsCount =  parseInt(localStorage.getItem("basketItemsCount"),10);
            let showBasket = false;
            if (basketItemsCount > 0){
                showBasket = true;
            }
           if (!showBasket){
               e.preventDefault();
           }
        });
    }

    function onBuyItemLinkClick(){
        $(".buyNewItemLink").click(e => {
            getBasketItemsCount();
        });
    }

    function showFiltersOnClick(){
        $(".showFiltersLink").click(e => {
            e.preventDefault();
            let asideWrap = $(".asideWrap");
            if (asideWrap){
                asideWrap.toggleClass("d-none");
            }
        });
    }

    async function asyncItemsCountDecrement(id){
        $.post("http://mvcShopLatest/template/asyncSettingData/decrementBasketItemsCount.php", {"id": id}, function (data,textStatus){
            setBasketItemsCount();
            return data;
        }, "json");
    }

    async function minusItemsCountOnClick(){
        let ids = await asyncGetBasketItemsIds();
        ids = ids.data;
        ids.forEach(id => {
            $(`.minusItemsCount${id}`).click(e => {
                e.preventDefault();
                asyncItemsCountDecrement(id);
            });
        });
    }

    async function asyncItemsCountIncrement(id){
        $.post("http://mvcShopLatest/template/asyncSettingData/incrementBasketItemsCount.php", {"id":id}, function (data, textStatus){
            setBasketItemsCount();
            return data;
        }, "json");
    }

    async function plusItemsCountOnClick(){
        let ids = await asyncGetBasketItemsIds();
        ids = ids.data;
        ids.forEach(id => {
            $(`.plusItemsCount${id}`).click(e => {
                e.preventDefault();
                asyncItemsCountIncrement(id);
            })
        });
    }

    async function asyncDeleteBasketItem(id){
        $.post("http://mvcShopLatest/template/asyncDeletingData/deleteBasketItemById.php", {"id":id}, function (data, textStatus){
            setBasketItemsCount();
            return data;
        }, "json");
    }

    function deleteBasketItemById(){
        $(".deleteBasketItem").click(e => {
            e.preventDefault();
            let id = $(".itemId").val();
            asyncDeleteBasketItem(id);
        })
    }

    function clearFooterStylesIfInMain(){
        if($(".cardContainer").length){
            $(".mainFooter").addClass("clearFromStyles");
        } else{
            $(".mainFooter").removeClass("clearFromStyles");
        }
    }

    async function asyncGetBasketItemsCountById(id){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsCountById.php", {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Content-type": "application/json"
            },
            body: JSON.stringify({"id":id})
        });
        return await rawData.json();
    }

    async function asyncGetBasketItemsIds(){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsIds.php");
        return await rawData.json();
    }

    async function setBasketItemsCount(){
        let data = await asyncGetBasketItemsIds();
        data.data.forEach(async id => {
            let currentBasketItemCount = await asyncGetBasketItemsCountById(id);
            $(`.showBasketItemCountInput${id}`).val(currentBasketItemCount.data);
        });
    }
    setBasketItemsCount();

    clearFooterStylesIfInMain();

    deleteBasketItemById();

    plusItemsCountOnClick();

    minusItemsCountOnClick();

    showFiltersOnClick();

    onBuyItemLinkClick();

    showBasketPageIfNotEmpty();

    getBasketItemsCount();

    activateSearchBar();

    closeSearchBar();

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