<div class="container">
    <div class="row">
        <div class="col-xs-8 col-sm-10 col-lg-12 mx-auto">
            <h2 class="text-center mt-4">Contact Us Here</h2>
            <hr class="underTitle mb-4" />

            <form action="models/formToEmail.php" method="POST" onSubmit="return checkFormClientSide();" >
                <div class="form-group">
                    <label for="firstNameContact">Your First Name</label>
                    <input type="text" class="form-control" name="firstNameContact" id="firstNameContact">
                </div>
                <div class="form-group">
                    <label for="formEmail">Your Email</label>
                    <input type="text" class="form-control" name="formEmail" id="formEmail">
                </div>
                <div class="form-group">
                    <label for="contentContact">Message</label>
                    <textarea class="form-control" name="contentContact" id="contentContact" rows="8"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="submit" id="btnSendMessage" name="btnSendMessage" class="btn btn-success" value="Send">
                </div>

                <div id="notification">
                    <?php
                    if (isset($_SESSION['contactErrors'])) {
                        $errors = $_SESSION['contactErrors'];
                        foreach ($errors as $one) {
                            echo $one . "<br/>";
                        }
                        unset($_SESSION['contactErrors']);
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>