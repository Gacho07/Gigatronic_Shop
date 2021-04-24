<div class="container">
    <div class="row">
        <div class="col-6 mx-auto">
            <h2 class="text-center mt-4">Insert Product</h2>
            <hr class="underTitle mb-4" />

            <form action="models/products/insert.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="articleName" placeholder="Enter article name" class="form-control" />
                </div>
                <div class="form-group">
                    <textarea name="taDescription" cols="30" rows="10" class="form-control" placeholder="Description"></textarea>
                </div>
                <div class="form-group">
                    <input type="number" name="price" class="form-control" placeholder="Enter price" />
                </div>
                <div class="form-group">
                    <input type="file" name="imageFile" class="form-control-file" />
                </div>
                <div class="form-group">
                    <input type="text" name="alt" placeholder="Enter alt attribute" class="form-control" />
                </div>
                <div class="form-group">
                    <select name="ddlCategory" class="form-control">
                        <option value="0">Choose category</option>
                        <?php
                        $categories = getCategories();
                        foreach ($categories as $cat) :
                        ?>
                            <option value="<?= $cat->idCategory ?>"><?= $cat->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" value="Upload" name="btnUpload" class="btn btn-success">
                </div>
            </form>
            <?php
            if (isset($_SESSION['msg'])) {
                var_dump($_SESSION['msg']);
                unset($_SESSION['msg']);
            }
            ?>
        </div>
    </div>
</div>