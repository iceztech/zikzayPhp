<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/3/2020
 *Time: 2:53 PM
 */
use Zikzay\Core\View;
?>
<?php View::start(); ?>

<div class="container-fluid p-md-5">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-footer">
                    <h1>Sign in</h1><br><br>
                    <?php include FORM_ERROR ?>
                    <form method="post" action="login/create" class="form">
                        <div class="row">
                        <div class="form-group col-md-12">
                            <label for="phone">Phone no: </label>
                            <input class="form-control" type="text" name="phone" id="phone">
                            <span id="phone-e"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="age">Password: </label>
                            <input class="form-control" type="text" name="password" id="password">
                            <span id="password-e"></span>
                        </div>
                        </div>
                        <div class="form-group">
                            <br>
                            <button class="btn btn-primary form-control" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php View::end(); ?>

