<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center mt-4">Users</h2>
            <hr class="underTitle mb-4" />
            <table class="table table-stripped table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Date Registration</th>
                    <th>Setup</th>
                </tr>
                <?php
                $users = getAllUsers();
                foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->idUser ?></td>
                        <td><?= $user->first_name ?></td>
                        <td><?= $user->last_name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->date_registration ?></td>
                        <td>
                            <a href="models/users/delete.php?id=<?= $user->idUser ?>" class="btn btn-danger">Delete</a>
                            <a href="#" class="btn btn-primary update-user" data-id="<?= $user->idUser ?>">Update</a>
                        </td>
                    <?php endforeach; ?>
                    </tr>
            </table>
        </div>
    </div>

    <div class="row update">
        <div class="col-md-6 mx-auto">
            <form action="models/users/update.php" method="POST">
                <input type="hidden" name="hiddenUserId" id="hiddenUserId">
                <div class="form-group">
                    <input type="text" placeholder="First Name" name="tbFirstName" id="tbFirstName" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Last Name" name="tbLastName" id="tbLastName" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Email" name="tbEmail" id="tbEmail" class=" form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Username" name="tbUsername" id="tbUsername" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" name="tbPassword" id="tbPassword" class="form-control">
                </div>
                <div class="form-group">
                    <select name="ddlRole" id="ddlRole" class="form-control">
                        <option value="0">choose role</option>
                        <?php 
                        $roles = getAllRoles();
                        foreach ($roles as $role) : ?>
                            <option value="<?= $role->idRole ?>"><?= $role->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="dateRegistration" id="dateRegistration" class="form-control">
                </div>
                <div class="form-group">
                    <label for="chbActive">Active user? Yes / No</label>
                    <input type="checkbox" name="chbActive" id="chbActive" value="1">
                </div>
                <input type="submit" value="Update" class="btn btn-success" name="btnUpdateUser">
            </form>
        </div>
    </div>

    <div class="updateResponse">
        <?php
        if (isset($_SESSION['message'])) :
            var_dump($_SESSION['message']);
            unset($_SESSION['message']);
        endif;
        ?>
    </div>
</div>