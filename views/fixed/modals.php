<!-- Start of product modal -->
<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="article_detail">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of product modal -->

<!-- Start of registration modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content registration">
            <div class="modal-header">
                <h5 class="modal-title">Registration Form</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegister" class="form">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" placeholder="Marko" id="firstName" />
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" placeholder="Luis" id="lastName" />
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" placeholder="luis117" id="username" />
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" placeholder="example@gmail.com" id="email" />
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" id="password" />
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <button class="btn btn-success" id="btnRegister">Register</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
            </div>
        </div>
    </div>
</div>
<!-- End of registration modal -->

<!-- Start of login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Form</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="models/login.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="tbEmail" placeholder="Your Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="tbPassword" placeholder="Your Password" class="form-control">
                    </div>

                    <input type="submit" value="Login" name="btnLogin" class="btn btn-success">
                </form>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-errors">
                    <?php
                    if (isset($_SESSION['errors'])) {
                        $errors = $_SESSION['errors'];
                        foreach ($errors as $one) {
                            echo $one . "<br/>";
                        }
                        unset($_SESSION['errors']);
                    }
                    ?>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
            </div>
        </div>
    </div>
</div>
<!-- End of login modal -->

