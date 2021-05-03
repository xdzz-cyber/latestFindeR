<main>

    <div class="welcomeHeader text-center">
        <h1 class="m-0 p-0">Welcome to findeR</h1>
        <p class="lead m-0 p-0">Find all the items that you need</p>
    </div>
    <?php if(!$params['items']): ?>
    <div class="noItemsFoundHeaderContainer">
        <h2>No items found</h2>
    </div>
    <?php endif; ?>


    <section class="d-grid">

        <div class="container-fluid d-grid cardContainer">
            <?php
            $i = 1;
            foreach ($params['items'] as $item):  ?>
                <div class="card my-sm-3 my-md-4 mx-md-3" style="grid-area: cardElement<?=$i++?>">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="img-fluid" src="/template/images/<?=$item['photo']?>" alt="single image photo">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><a class="text-decoration-none" href="/clientPagesShow/singleItemPage/<?=$item['id']?>"><?=$item['name']?></a></h5>
                                <p class="card-text"><?=$item['description']?></p>
                                <p class="card-text"><small class="text-muted">Published at <?=$item['publish_date']?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="asideWrap position-absolute d-none">
            <aside class="asideNav d-inline-block">
                <form class="findByFiltersForm" action="/clientItems/findItemsByFilters" method="post">
                    <div class="pt-3">
                        <div class="mt-sm-2 mb-sm-2 mb-3">
                            <input type="text" class="minPrice d-inline-block form-control w-25 form-control-sm" name="minPrice" value="<?= $params['minPrice'] ?>">
                            -
                            <input type="text" class="maxPrice d-inline-block form-control w-25 form-control-sm" name="maxPrice" value="<?= $params['maxPrice'] ?>">


                            <div class="findByPriceButtonContainer mt-sm-4 mb-sm-4">
                                <input type="submit" class="findByFilters btn btn-sm btn-primary text-white" value="Search">
                            </div>

                        </div>
                            <div class="mt-sm-2 mb-sm-2" id="slider-range"></div>
                    </div>

                    <div class="mt-sm-2 mb-sm-2 pt-3">
                        <label for="findByMonthNYear" class="form-label">Find by month and year</label>
                        <input type="date" class="form-control form-control-sm" name="findByDate">
                    </div>

                    <div class="mt-sm-2 mb-sm-2 pt-5">
                        <label for="" class="form-label">Find by category</label>
                        <select name="findByCategory" id="findByCategory" class="form-select">
                            <?php
                                foreach ($params['categories'] as $category):
                            ?>
                                    <option value="<?=$category['id']?>"><?=$category['category_name']?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </form>
            </aside>
        </div>




        <nav class="paginationNav">
            <ul class="pagination justify-content-center">

                <?php

                    if ($params['numPages'] > 0){
                        if($params['hasPrev']){
                            echo "<li class='page-item'><a class='page-link' href='/clientItems/clientPagination/{$params['prev']}'>Previous</a></li>";
                        } else{
                            echo "<li class='page-item disabled'><a class='page-link'>Previous</a></li>";
                        }

                        for($i = 1;$i <= $params['numPages']; $i++){
                            if($params['current_page'] == $i){
                                echo "<li class='page-item'><a class='page-link active' href='/clientItems/clientPagination/{$i}'>$i</a></li>";
                            } else{
                                echo "<li class='page-item'><a class='page-link' href='/clientItems/clientPagination/{$i}'>$i</a></li>";
                            }
                        }

                        if($params['hasNext']){
                            echo "<li class='page-item'><a class='page-link' href='/clientItems/clientPagination/{$params['next']}'>Next</a></li>";
                        } else{
                            echo "<li class='page-item disabled'><a class='page-link'>Next</a></li>";
                        }
                    }


                ?>
            </ul>
        </nav>
    </section>

</main>
