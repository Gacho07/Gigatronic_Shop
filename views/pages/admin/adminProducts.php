<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center mt-4">All Products</h2>
            <hr class="underTitle mb-4" />
            <table class="table table-stripped table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Setup</th>
                </tr>
                <?php
                $articles = getAllArticles();
                foreach ($articles as $article) :
                ?>
                    <tr>
                        <td><?= $article->idArticle ?></td>
                        <td><?= $article->name ?></td>
                        <td>$<?= $article->price ?></td>
                        <td align="center"><img src="<?= $article->image ?>" alt="<?= $article->alt ?>" width="80" height="80"></td>
                        <td><?= $article->categoryName ?></td>
                        <td>
                            <a href="models/products/delete.php?id=<?=$article->idArticle?>" class="btn btn-danger">Delete</a>
                            <a href="#" class="btn btn-primary update-product" data-id="<?=$article->idArticle?>">Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="row update">
        <div class="col-md-6 mx-auto">
            <form action="models/products/update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="hiddenProductID" id="hiddenProductID">
                <div class="form-group">
                    <input type="text" name="productName" id="productName" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="taDescription" id="taDescription" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="productPrice" id="productPrice" class="form-control">
                </div>
                <img src="" alt="" style="width:20%;" id="emptyImage" name="emptyImage">
                <div class="form-group">
                    <input type="file" name="productImage" id="productImage">
                </div>
                
                <div class="form-group">
                    <input type="text" name="productAlt" id="productAlt" class="form-control">
                </div>
                <div class="form-group">
                    <select name="ddlCategory" id="ddlCategory" class="form-control">
                        <option value="0">Choose category</option>
                        <?php
                        $categories = getCategories();
                        foreach ($categories as $cat) : ?>
                            <option value="<?= $cat->idCategory ?>"><?= $cat->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="Update" class="btn btn-success" name="btnUpdateProduct">
            </form>
        </div>
    </div>

    <div class="update-response">
        <?php
            if (isset($_SESSION['errorUpdate'])) {
                echo $_SESSION['errorUpdate'];
                unset($_SESSION['errorUpdate']);
            }
        ?>
    </div>
</div>