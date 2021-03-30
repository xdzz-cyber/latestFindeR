<main>
    .
    <div class="welcomeHeader text-center">
        <h1 class="m-0 p-0">Welcome to findeR</h1>
        <p class="lead m-0 p-0">Find all the items that you need</p>
    </div>

    <section>
        <div class="asideWrap">
            <aside class="asideNav d-inline-block">
                <form action="/clientItems/find" method="post">
                    <div class="pt-3">
                        
                        <div class="mb-3">
                            <input type="text" class="minPrice d-inline-block form-control w-25 form-control-sm" name="minPrice" value="<?= $params['minPrice'] ?>">
                            -
                            <input type="text" class="maxPrice d-inline-block form-control w-25 form-control-sm" name="maxPrice" value="<?= $params['maxPrice'] ?>">


                            <div class="d-inline-block findByPriceLabel">
                                <label class="form-label"><a class="findByPrice badge bg-primary text-wrap text-white text-decoration-none" href="">Search</a></label>
                            </div>

                        </div>
                            <div id="slider-range"></div>
<!--                        <input id="fromPrice" type="range" class="form-range" min="--><?//= $params['minPrice'] ?><!--" max="--><?//= $params['maxPrice'] ?><!--" step="5">-->
                    </div>
                    
                    <div class="pt-3">
                        <label for="findByMonthNYear" class="form-label">Find by month and year</label>
                        <input type="date" class="form-control form-control-sm" name="findByDate">
                    </div>

                    <div class="pt-5">
                        <label for="" class="form-label">Find by category</label>
                        <select name="findCategory" id="findCategory" class="form-select">
                            <option value="first" selected>first</option>
                        </select>
                    </div>
                </form>
            </aside>
        </div>


        <div class="container cardContainer">
            <?php foreach ($params['items'] as $item):  ?>
            <div class="card my-md-4 mx-md-3">
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

        <nav>
            <ul class="pagination justify-content-center">

                <?php
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
                ?>
            </ul>
        </nav>
    </section>

</main>