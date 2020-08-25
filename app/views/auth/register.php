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
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-footer">
                    <h1>Sign up</h1><br><br>
                    <?php include FORM_ERROR ?>
                    <form method="post" action="register/create" class="form">
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name: </label>
                            <input class="form-control" type="text" name="firstname" id="firstname">
                            <span id="firstname-e"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname"><i class="fas fa-user"></i> Last Name: </label>
                            <input  class="form-control" type="text" name="lastname" id="lastname">
                            <span id="lastname-e"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email">Email Address: </label>
                            <input class="form-control" type="text" name="email" id="email">
                            <span id="email-e"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone no: </label>
                            <input class="form-control" type="text" name="phone" id="phone">
                            <span id="phone-e"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="age">Password: </label>
                            <input class="form-control" type="text" name="password" id="password">
                            <span id="password-e"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">State: </label>
                            <input class="form-control" type="text" name="state" id="state">
                            <span id="state-e"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lga">LGA: </label>
                            <input class="form-control" type="text" name="lga" id="lga">
                            <span id="lga-e"></span>
                        </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary form-control" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php View::end(); ?>

