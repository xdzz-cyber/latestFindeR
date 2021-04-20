<?php //var_dump($_SESSION['basket']); ?>

<main>

    <div class="singleItemHeaderContainer text-center">
        <h2>Check this out</h2>
        <p class="singleItemText lead">Here you can find everything about the product that you've been looking for, and don't  be shy and ask questions if needed or simply contact us by the given address!</p>
    </div>

    <div class="row mw-100">
        <div class="card mx-auto">
            <img src="/template/images/<?=$params['item']['photo']?>" alt="single item image" class="singleItemImage card-img-top text-center">
            <div class="card-body">
                <h5 class="card-title"><?=$params['item']['name']?></h5>
                <p class="card-text"><?=$params['item']['description']?></p>
                <p class="lead">Published at <?=$params['item']['publish_date']?></p>
                <a href="/clientBasket/addItem/<?=$params['item']['id']?>" class="buyNewItemLink btn btn-success">Buy for <?=$params['item']['price']?></a>
            </div>
        </div>
    </div>

</main>
