<?php
include 'inc/controllers/managerController.php';
?>
<!DOCTYPE html>
<html>
<?php
include 'inc/view/header.php';
?>
<body>

<?php
$activeTab = 'manager';
include 'inc/view/navbar.php';
?>


<!-- container class inside Bootstrap can center the page content and it also sets the containers max width at every media query break point. -->
<div class="container documentationbar">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-2 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="query">
                <form method="get" action="">
                    <fieldset>
                        <legend>SEARCH MANAGER</legend>
                        <label for="lmanagername">Manager</label>
                        <input type="text" id="managername" name="managername"
                               value="<?php echo getFormData('managername'); ?>">

                        <label for="lcountry">Nationality</label>
                        <input type="text" id="countryname" name="managercountry"
                               value="<?php echo getFormData('managercountry'); ?>">

                        <label for="lclubname">Manager's Club</label>
                        <input type="text" id="clubname" name="clubname" value="<?php echo getFormData('clubname'); ?>">
                        <hr>

                        <label for="lminage">Minimum Age</label>
                        <input type="text" id="lminage" name="managerminage"
                               value="<?php echo getFormData('managerminage'); ?>">

                        <label for="lmaxage">Maximum Age</label>
                        <input type="text" id="lmax" name="managermaxage"
                               value="<?php echo getFormData('managermaxage'); ?>">

                        <input type="submit" value="Search">
                    </fieldset>
                </form>
            </div>
        </div><!--/.sidebar-offcanvas-->


        <div class="col-xs-12 col-lg-9">

            <div class="jumbotron">
                <form method="post" action="">
                    <?php addManager() ?>
                    <fieldset>
                        <legend>Add a Manager:</legend>
                        <label for="lmanagername">Manager Name</label>
                        <input type="text" id="managername" name="AddManagerName"
                               value="<?php echo getFormData('AddManagerName'); ?>">

                        <label for="lcountry">Nationality</label>
                        <input type="text" id="countryname" name="AddManagerCountry"
                               value="<?php echo getFormData('AddManagerCountry'); ?>">

                        <label for="age">Age</label>
                        <input type="number" id="age" name="AddManagerAge"
                               value="<?php echo getFormData('AddManagerAge'); ?>">

                        <input type="submit" value="Add Manager" name="AddManager">

                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php editManager() ?>
                    <fieldset>
                        <legend>Update a Manager:</legend>
                        <label for="lmanagername">Please enter the manager's name you want to update:</label>
                        <input type="text" id="updatemanagername" name="UpdateManagerName"
                               value="<?php echo getFormData('UpdateManagerName'); ?>">
                        <br>

                        <legend>What do you want to update?</legend>
                        <label for="lcountry">Country</label>
                        <input type="text" id="updatecountryname" name="UpdateManagerCountry"
                               value="<?php echo getFormData('UpdateManagerCountry'); ?>">

                        <label for="age">Age</label>
                        <input type="number" id="updatemanagerage" name="UpdateManagerAge"
                               value="<?php echo getFormData('UpdateManagerAge'); ?>">

                        <input type="submit" value="Update Manager" name="ModifyManager">
                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php deleteManager() ?>
                    <fieldset>
                        <legend>Delete a Manager:</legend>
                        <label for="lmanagername">Please enter the manager that you want to delete</label>
                        <input type="text" id="deletemanagername" name="DeleteManagerName"
                               value="<?php echo getFormData('DeleteManagerName'); ?>">

                        <input type="submit" value="Delete Manager" name="DeleteManager">
                    </fieldset>
                </form>
            </div>


            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <form method="get" action="">
                        <table id="t01">
                            <tr>
                                <th>Manager ID</th>
                                <th>Manager Name</th>
                                <th>Age</th>
                                <th>Nationality</th>
                            </tr>
                            <?php viewManagers() ?>
                        </table>
                        <br>
                        <br>
                    </form>

                </div><!--/.col-xs-6.col-lg-4-->

            </div><!--/row-->

        </div><!--/.col-xs-12.col-sm-9-->

    </div><!--/row-->
</div>
<?php
include 'inc/view/footer.php';
?>
</body>
</html>
