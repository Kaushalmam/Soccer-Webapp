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
                        <legend>MANAGER PERFORMANCE</legend>
                        <label for="lmanagername">Manager</label>
                        <input type="text" id="managername" name="managername"
                               value="<?php echo getFormData('managername'); ?>">

                        <label for="lcountry">Nationality</label>
                        <input type="text" id="countryname" name="managercountry"
                               value="<?php echo getFormData('managercountry'); ?>">

                        <label for="lclubname">Manager's Club</label>
                        <input type="text" id="clubname" name="clubname"
                               value="<?php echo getFormData('clubname'); ?>">
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

            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <form method="get" action="">
                        <table id="t01">
                            <tr>
                                <th>Manager ID</th>
                                <th>Manager Name</th>
                                <th>Win Percentage</th>
                                <th>Nationality</th>
                            </tr>
                            <?php viewManagerStats() ?>
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
