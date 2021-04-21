<?php var_dump($_SESSION['basket']); ?>

<main>
    <?php
    foreach ($_SESSION['basket'] as $item):
        ?>
        <div class="row basketSingleItemContainer<?=$item['id']?> text-center">
            <div class="col-sm-6 col-md-12">
                <h5 class="card-title"><?= $item['name'] ?></h5>
                <img class="basketSingleImage img-fluid me-3" src="/template/images/<?= $item['photo'] ?>" alt="">


                <a class="minusItemsCount<?=$item['id']?> me-2" href=""><i class="fa fa-minus"></i></a>
                <input type="hidden" name="itemId" class="itemId<?=$item['id']?>" value="<?=$item['id']?>">
<!--                <input class="basketItemCountInput" value="1" min="1" type="range">-->
                <input type="text" class="showBasketItemCountInput<?=$item['id']?> form-control-sm">
                <a class="plusItemsCount<?=$item['id']?>" href=""><i class="fa fa-plus"></i></a>

                <div class="d-inline-block ms-5">
                    <h5 class="basketItemPrice<?=$item['id']?> d-inline-block pe-3"><?=$item['price']?>$</h5>
                    <a href="#" class="btn btn-success">Submit buy</a>
                    <a href="/clientBasket/showBasketItems" class="deleteBasketItem<?=$item['id']?> btn btn-danger ms-lg-3">Delete</a>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

    <nav aria-label="Page navigation" class="basketPaginationNav">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>

</main>