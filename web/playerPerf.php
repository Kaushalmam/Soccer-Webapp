<?php
include 'inc/controllers/playerController.php';
?>
<!DOCTYPE html>
<html>
<?php
include 'inc/view/header.php';
?>
<body>
<?php
$activeTab = 'player';
include 'inc/view/navbar.php';
?>
<!-- container class inside Bootstrap can center the page content and it also sets the containers max width at every media query break point. -->
<div class="container documentationbar">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-2 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="query">
                <form method="get" action="">
                    <fieldset>
                        <legend>PLAYER PERFORMANCE</legend>

                        <label for="stat">Stat (Default Value: Goals Scored)</label>
                        <select id="stat" name="stat" value="<?php echo getFormData('stat'); ?>">
                            <option value=""></option>
                            <option value="score">Goals</option>
                            <option value="assist">Assists</option>
                            <option value="card">Cards</option>
                        </select>

                        <label for="lclubname">Player's Club</label>
                        <input type="text" id="clubname" name="clubname"
                               value="<?php echo getFormData('clubname'); ?>">
                        <hr>
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
                                <th>Club Name</th>
                                <th>Player Name</th>
                                <th>Stat</th>
                            </tr>
                            <?php viewPlayerStats() ?>
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
