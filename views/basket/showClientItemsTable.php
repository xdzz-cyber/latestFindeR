<main>
    <div class="showClientItemsTableHeaderContainer">
        <h1 class="text-center">Welcome to final show table of basket items</h1>
        <div class="d-flex justify-content-center mt-4">
            <a href="/clientBasket/finalSubmitBasketItems" class="btn btn-info me-4">Final submit of order</a>
            <a href="/clientItems/clientPagination/1" class="btn btn-danger">Cancel</a>
        </div>
    </div>

    <table class="showClientItemsTable mx-auto">
        <thead>
        <tr>
            <th>№</th>
            <th>Name</th>
            <th>Price</th>
            <th>Photo</th>
            <th>Count</th>
        </tr>
        </thead>
       <tbody>
       <?php
        $i = 1;
        foreach ($_SESSION['basket'] as $item):
       ?>
       <tr>
           <td><?=$i++?></td>
           <td><?=$item['name']?></td>
           <td><?=$item['price']?></td>
           <td><img alt="single item image" class="showClientItemsTableSingleImage img-fluid" src="/template/images/<?=$item['photo']?>"></td>
           <td><?=$item['count']?></td>
       </tr>
       <?php
        endforeach;
       ?>
       </tbody>
    </table>
</main>
