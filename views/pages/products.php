<div class="container">
    <div class="row">
        <div class="col-xs-8 col-sm-10 col-lg-12 mx-auto">
            <h2 class="text-center mt-4">Our Products</h2>
            <hr class="underTitle mb-4" />
            <div class="category-list">
                <select name="ddlCategory" id="ddlCategory" class="custom-select my-4">
                    <option value="0">Choose category</option>
                    <?php
                    $categories = getCategories();
                    foreach ($categories as $cat) :
                    ?>
                        <option value="<?= $cat->idCategory ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="allArticles" class="filter_data row mt-4">

            </div>

            <div id="pagination">
                <ul id="pagination-list">

                </ul>
            </div>
        </div>
    </div>
</div>