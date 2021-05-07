<?php var_dump($_SESSION['basket']); ?>
<main>
    <div class="totalBasketItemsSumContainer text-center mb-5">
        <h1 class="basketItemsTotalSumHeader">Total sum is <span class="basketItemsTotalSumShowElement"></span> $</h1>
        <div class="d-flex justify-content-center">
            <h3 class=""><a href="/clientItems/clientPagination/1" class="clearBasketLink btn btn-warning mt-3 me-3">Clear Basket</a></h3>
            <h3><a href="/clientUser/clientLogin" class="submitAllItemsLink btn btn-success mt-3">Submit all items</a></h3>
        </div>
    </div>
    <?php

    $next = $params['current_page'] + 1;
    $prev = $params['current_page'] - 1;
    $numPages = $params['numPages'];

    foreach ($params['items'] as $item):
        ?>
        <div class="row basketSingleItemContainer<?=$item['id']?> text-center">
            <div class="singleBasketElementContainer col-md-12">
                <h5 class="card-title"><?= $item['name'] ?></h5>
                <img class="basketSingleImage img-fluid me-3" src="/template/images/<?= $item['photo'] ?>" alt="">


                <a class="minusItemsCount<?=$item['id']?> me-2" href="/clientBasket/showBasketItems/<?=$prev?>"><i class="fa fa-minus"></i></a>
                <input type="hidden" name="itemId" class="itemId<?=$item['id']?>" value="<?=$item['id']?>">
                <input type="number" min="1" max="<?=$item['maxItemCount']?>" class="showBasketItemCountInput<?=$item['id']?> singleBasketCountInput form-control-sm">
                <a class="plusItemsCount<?=$item['id']?>" href=""><i class="fa fa-plus"></i></a>

                <div class="d-inline-block ms-5">
                    <h5 class="basketItemPrice<?=$item['id']?> d-inline-block pe-3"><?=$item['price']?>$</h5>
                    <a href="/clientUser/clientLogin" class="singleSubmitBuyButton btn btn-success">Submit buy</a>
                    <a href="/clientBasket/showBasketItems/1" class="singleDeleteBasketItemButton deleteBasketItem<?=$item['id']?> btn btn-danger ms-lg-3">Delete</a>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

    <nav aria-label="Page navigation" class="basketPaginationNav fixed-bottom">
        <ul class="pagination justify-content-center">
            <?php
                if ($params['current_page'] != 1):
            ?>
            <li class="page-item"><a class="page-link" href="/clientBasket/showBasketItems/<?=$prev?>">Previous</a></li>
            <?php
                else:
            ?>
            <li class="page-item disabled"><a class="page-link" href="/clientBasket/showBasketItems/<?=$prev?>">Previous</a></li>
            <?php
                endif;
                for ($i = 1;$i <= $numPages; $i++):
            ?>
            <li class="page-item"><a class="page-link" href="/clientBasket/showBasketItems/<?=$i?>"><?=$i?></a></li>
            <?php
            endfor;
            ?>

            <?php if($params['current_page'] != $numPages): ?>
            <li class="page-item"><a class="page-link" href="/clientBasket/showBasketItems/<?=$next?>">Next</a></li>
            <?php
                else:
            ?>
            <li class="page-item disabled"><a class="page-link" href="/clientBasket/showBasketItems/<?=$next?>">Next</a></li>
            <?php
                endif;
            ?>
        </ul>
    </nav>

</main>