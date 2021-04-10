<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/template/css/general.css">
    <link rel="stylesheet" href="/template/css/mobileFirstApproachStyles.css">
    <script src="https://use.fontawesome.com/534c07024c.js"></script>
    <script src="/jQuery/jquery-3.5.1.min.js"></script>
    <title>Document</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="mainHeaderContainer container">
            <a class="navbar-brand" href="/clientPagesShow/aboutPage">findeR</a>

                <ul class="mainHeaderNavbarNav justify-content-evenly navbar-nav mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/clientItems/clientPagination/1">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/clientPagesShow/aboutPage">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/clientPagesShow/contactPage">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/clientUser/logout">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../admin/items/pagination/1">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-shopping-basket"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="openSearchElement nav-link"><i class="fa fa-search"></i></a>
                    </li>
                </ul>


                <div class="searchFormContainer d-none">
                    <form action="/clientItems/findItemsByName" method="post" class="searchItemsForm d-flex">
                        <input class="searchItemsInput form-control" name="searchName" type="search" placeholder="Search" aria-label="Search">
                        <div>
                            <a class="closeSearchElement"><i class="fa fa-window-close"></i></a>
                        </div>
                    </form>
                </div>


        </div>
    </nav>
</header>