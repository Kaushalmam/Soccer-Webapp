<?php
include 'inc/controllers/matchController.php';
?>
<!DOCTYPE html>
<html>
<?php
include 'inc/view/header.php';
?>
<body>
<?php
$activeTab = 'season';
include 'inc/view/navbar.php';
?>

<!-- container class inside Bootstrap can center the page content and it also sets the containers max width at every media query break point. -->
<div class="container documentationbar">

    <div class="row row-offcanvas row-offcanvas-right">
        <?php
        $title = 'DETAILED STATS BY SEASON';
        include 'inc/view/seasonSideBar.php';
        ?>
        <div class="col-xs-12 col-lg-9">

            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <form method="get" action="">
                        
                        <table id="t01">
                            <tr>
                                <th>Season Year</th>
                                <th>Club Name</th>
                                <th>Home Wins</th>
                                <th>Home Draws</th>
                                <th>Home Defeats</th>
                                <th>Away Wins</th>
                                <th>Away Draws</th>
                                <th>Away Defeats</th>
                            </tr>
                            <?php viewMatches() ?>
                        </table>
                        <br>
                        <br>
                    </form>

                </div><!--/.col-xs-6.col-lg-4-->

            </div><!--/row-->

        </div>
        <!--/.col-xs-12.col-sm-9-->

    </div><!--/row-->
</div>
<?php
include 'inc/view/footer.php';
?>
</body>
</html>
