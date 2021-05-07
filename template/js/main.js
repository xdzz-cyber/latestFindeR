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
            } else {
                $.removeCookie("client_search_name", {path: "/"});
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

    function activateSearchBar() {
        $(".openSearchElement").click(e => {
            e.preventDefault();
            $(".mainHeaderNavbarNav").hide();
            $(".searchFormContainer").toggleClass("d-none");
        });
    }

    function closeSearchBar() {
        $(".closeSearchElement").click(e => {
            e.preventDefault();
            $(".searchFormContainer").toggleClass("d-none");
            $(".mainHeaderNavbarNav").show();
        })
    }

    async function getBasketItemsCount() {
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsCount.php");
        let json_data = await rawData.json();
        return json_data.count;
    }

    async function setBasketItemsCountToUI(){
        let data = await getBasketItemsCount();
        $(".fa-shopping-basket").append(data);
        localStorage.setItem("basketItemsCount", data);
    }

    function showBasketPageIfNotEmpty() {

        $(".basketItemsPageLink").click(e => {
            let basketItemsCount = parseInt(localStorage.getItem("basketItemsCount"), 10);
            let showBasket = false;
            if (basketItemsCount > 0) {
                showBasket = true;
            }
            if (!showBasket) {
                e.preventDefault();
            }
        });
    }

    function onBuyItemLinkClick() {
        $(".buyNewItemLink").click(e => {
            setBasketItemsCountToUI();
        });
    }

    function showFiltersOnClick() {
        $(".showFiltersLink").click(e => {
            e.preventDefault();
            let asideWrap = $(".asideWrap");
            if (asideWrap) {
                asideWrap.toggleClass("d-none");
            }
        });
    }

    async function asyncItemsCountDecrement(id) {
        $.post("http://mvcShopLatest/template/asyncSettingData/decrementBasketItemsCount.php", {"id": id}, function (data, textStatus) {
            setBasketItemsCount();
            setBasketItemsPrice();
            setBasketItemsTotalSum();
            return data;
        }, "json");
    }

    async function minusItemsCountOnClick() {
        let ids = await asyncGetBasketItemsIds();
        let distinctBasketElementsCount = await asyncGetDistinctBasketItemsCount();
        ids.forEach(id => {
            $(`.minusItemsCount${id}`).click(e => {
                distinctBasketElementsCount-=1;
                let currentItemCount = parseInt($(`.showBasketItemCountInput${id}`).val(),10);
                if(currentItemCount === 1){
                    if(distinctBasketElementsCount === 0 || distinctBasketElementsCount % 3 !== 0){  /* 3 - MAGIC NUMBER */
                        e.preventDefault();
                        removeElementFromUIById(id);
                    }
                    asyncDeleteBasketItem(id);
                    showSubmitButtonOnBasketItemsCountChange();
                    if(distinctBasketElementsCount < 2){
                        window.location.href = "http://mvcshoplatest/clientItems/clientPagination/1"
                    }
                } else{
                    e.preventDefault();
                    asyncItemsCountDecrement(id);
                }
            });
        });
    }

    async function asyncItemsCountIncrement(id) {
        $.post("http://mvcShopLatest/template/asyncSettingData/incrementBasketItemsCount.php", {"id": id}, function (data, textStatus) {
            setBasketItemsCount();
            setBasketItemsPrice();
            setBasketItemsTotalSum();
            return data;
        }, "json");
    }

    async function plusItemsCountOnClick() {
        let ids = await asyncGetBasketItemsIds();
        let getMaxItemsIds = await getEveryItemCountArray();

        console.log(getMaxItemsIds);

        ids.forEach(id => {
            $(`.plusItemsCount${id}`).click(e => {
                e.preventDefault();
                debugger
                let currentItemInputValue = parseInt($(`.showBasketItemCountInput${id}`).val());
                getMaxItemsIds.forEach(el => {
                   if(el.id === id && parseInt(el.count) > currentItemInputValue){
                       asyncItemsCountIncrement(id);
                   }
                });
            })
        });
    }

    async function asyncDeleteBasketItem(id) {
        $.post("http://mvcShopLatest/template/asyncDeletingData/deleteBasketItemById.php", {"id": id}, function (data, textStatus) {
            setBasketItemsTotalSum();
            return data.data;
        }, "json");
    }

    async function asyncGetDistinctBasketItemsCount(){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getDistinctBasketItemsCount.php");
        let response = await rawData.json();
        return response.data;
    }


    async function deleteBasketItemById() {
        let ids = await asyncGetBasketItemsIds();
        let distinctBasketElementsCount = await asyncGetDistinctBasketItemsCount();
        ids.forEach(id => {
            $(`.deleteBasketItem${id}`).click(async e => {
                distinctBasketElementsCount-=1;
                if(distinctBasketElementsCount === 0 || distinctBasketElementsCount % 3 !== 0){  /* 3 - IS A MAGIC NUMBER */
                    e.preventDefault();
                    removeElementFromUIById(id);
                }
                let deleteResponse = await asyncDeleteBasketItem(id);
                showSubmitButtonOnBasketItemsCountChange();
                if(distinctBasketElementsCount < 2){
                    window.location.href = "http://mvcshoplatest/clientItems/clientPagination/1"
                }
            })
        });
    }

    function removeElementFromUIById(id){
        $(`.basketSingleItemContainer${id}`).remove();
    }

    function clearFooterStylesIfInMain() {
        if ($(".cardContainer").length) {
            $(".mainFooter").addClass("clearFromStyles");
        } else {
            $(".mainFooter").removeClass("clearFromStyles");
        }
    }

    async function asyncGetBasketItemsCountById(id) {
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsCountById.php", {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Content-type": "application/json"
            },
            body: JSON.stringify({"id": id})
        });
        return await rawData.json();
    }

    async function asyncGetBasketItemsIds() {
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsIds.php");
        let parseData = await rawData.json();
        return parseData.data;
    }

    async function setBasketItemsCount() {
        let data = await asyncGetBasketItemsIds();
        data.forEach(async id => {
            let currentBasketItemCount = await asyncGetBasketItemsCountById(id);
            $(`.showBasketItemCountInput${id}`).val(currentBasketItemCount.data);
        });
    }

    async function getBasketList() {
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketList.php");
        let basketList = await rawData.json();
        return basketList.data;
    }

    async function setBasketItemsPrice() {
        let updatedBasketList = await getBasketList();
        updatedBasketList.forEach(el => {
            if ($(`.itemId${el.id}`)) {
                let newPrice = parseInt(el.count, 10) * parseInt(el.price, 10);
                newPrice = newPrice.toString(10);
                $(`.basketItemPrice${el.id}`).text(`${newPrice}$`);
            }
        });
    }

    async function getBasketItemsTotalSum(){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getBasketItemsTotalSum.php");
        let response = await rawData.json();
        return response.data;
    }

    async function setBasketItemsTotalSum(){
        let totalSum = await getBasketItemsTotalSum();
        $(".basketItemsTotalSumShowElement").text(totalSum.toString());
    }

    async function clearBasketItems(){
        let rawData = await fetch("http://mvcShopLatest/template/asyncDeletingData/clearBasketItems.php");
        let response = await rawData.json();
        return response.data;
    }

    async function wipeOffBasketItemsOnClick(){
        $(".clearBasketLink").click(e => {
            clearBasketItems();
        })
    }

    function showSingleBasketSubmitButton(){
        $(".submitAllItemsLink").hide();
        $(".singleSubmitBuyButton").show();
    }

    function showAllBasketSubmitButton(){
        $(".singleSubmitBuyButton").hide();
        $(".submitAllItemsLink").show();
    }

    async function showSubmitButtonOnBasketItemsCountChange(){
        let distinctBasketItemsCount = await asyncGetDistinctBasketItemsCount();
        distinctBasketItemsCount > 1 ? showAllBasketSubmitButton() : showSingleBasketSubmitButton();
    }

    async function getEveryItemCountArray(){
        let rawData = await fetch("http://mvcShopLatest/template/gettingAsyncData/getEveryItemCountArray.php");
        let parsedData = await rawData.json();
        console.log(parsedData.data);
        return parsedData.data;
    }


    showSubmitButtonOnBasketItemsCountChange();

    wipeOffBasketItemsOnClick();

    setBasketItemsTotalSum();

    setBasketItemsPrice();

    setBasketItemsCountToUI();

    clearFooterStylesIfInMain();

    deleteBasketItemById();

    plusItemsCountOnClick();

    minusItemsCountOnClick();

    showFiltersOnClick();

    onBuyItemLinkClick();

    showBasketPageIfNotEmpty();

    setBasketItemsCount();

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