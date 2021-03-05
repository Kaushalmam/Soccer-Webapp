<?php
include 'inc/controllers/clubController.php';
?>
<!DOCTYPE html>
<html>
<?php
include 'inc/view/header.php';
?>
<body>
<?php
$activeTab = 'club';
include 'inc/view/navbar.php';
?>
<!-- container class inside Bootstrap can center the page content and it also sets the containers max width at every media query break point. -->
<div class="container documentationbar">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-2 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="query">
                <form method="get" action="">
                    <fieldset>
                        <legend>SEARCH CLUB</legend>
                        <label for="lclubname">Club Name</label>
                        <input type="text" id="clubname" name="clubname"
                               value="<?php echo getFormData('clubname'); ?>">

                        <label for="lhomestadium">Stadium Name</label>
                        <input type="text" id="homestadium" name="homestadium"
                               value="<?php echo getFormData('homestadium'); ?>">

                        <label for="league">League</label>
                        <select id="league" name="league" value="<?php echo getFormData('league'); ?>">
                            <option value=""></option>
                            <option value="Premier League">Premier League</option>
                            <option value="La Liga">La Liga</option>
                            <option value="Bundesliga">Bundesliga</option>
                        </select>

                        <label for="lmanagername">Manager Name</label>
                        <input type="text" id="managername" name="managername"
                               value="<?php echo getFormData('managername'); ?>">

                        <label for="lplayername">Player Name</label>
                        <input type="text" id="playername" name="playername"
                               value="<?php echo getFormData('playername'); ?>">
                        <hr>

                        <input type="submit" value="Search">
                    </fieldset>
                </form>
            </div>
        </div><!--/.sidebar-offcanvas-->


        <div class="col-xs-12 col-lg-9">

            <div class="jumbotron">
                <form method="post" action="">
                    <?php addClub(); ?>
                    <fieldset>
                        <legend>Add a Club:</legend>
                        <label for="lclubname">Club Name</label>
                        <input type="text" id="addclubname" name="AddClubName"
                               value="<?php echo getFormData('AddClubName'); ?>">

                        <label for="lcountry">Country</label>
                        <input type="text" id="countryname" name="AddClubCountry"
                               value="<?php echo getFormData('AddClubCountry'); ?>">

                        <label for="lstadium">Home Stadium</label>
                        <input type="text" id="stadiumname" name="AddHomeStadium"
                               value="<?php echo getFormData('AddHomeStadium'); ?>">

                        <label for="position">League</label>
                        <select id="position" name="AddClubLeague"
                                value="<?php echo getFormData('AddClubLeague'); ?>">
                            <option value=""></option>
                            <option value="Premier League">Premier League</option>
                            <option value="La Liga">La Liga</option>
                            <option value="Bundesliga">Bundesliga</option>
                        </select>

                        <input type="submit" value="Add Club" name="AddClub">

                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php editClub() ?>
                    <fieldset>
                        <legend>Update a Club:</legend>
                        <label for="lclubname">Please enter the club name you want to update:</label>
                        <input type="text" id="updateclubname" name="UpdateClubName"
                               value="<?php echo getFormData('UpdateClubName'); ?>">
                        <br>

                        <legend>What do you want to update?</legend>
                        <label for="lcountry">Country </label>
                        <input type="text" id="updatecountryname" name="UpdateClubCountry"
                               value="<?php echo getFormData('UpdateClubCountry'); ?>">

                        <label for="lstadium">Home Stadium</label>
                        <input type="text" id="stadiumname" name="UpdateHomeStadium"
                               value="<?php echo getFormData('UpdateHomeStadium'); ?>">

                        <label for="position">League</label>
                        <select id="updateposition" name="UpdateClubLeague"
                                value="<?php echo getFormData('UpdateClubLeague'); ?>">
                            <option value=""></option>
                            <option value="Premier League">Premier League</option>
                            <option value="La Liga">La Liga</option>
                            <option value="Bundesliga">Bundesliga</option>
                        </select>

                        <input type="submit" value="Modify Club" name="ModifyClub">
                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php deleteClub() ?>
                    <fieldset>
                        <legend>Delete a Club:</legend>
                        <label for="lclubname">Please enter the club name you want to delete:</label>
                        <input type="text" id="deleteclubname" name="DeleteClubName"
                               value="<?php echo getFormData('DeleteClubName'); ?>">

                        <input type="submit" value="Delete Club" name="DeleteClub">
                    </fieldset>
                </form>
            </div>


            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <form method="get" action="">
                        <table id="t01">
                            <tr>
                                <th>Club ID</th>
                                <th>Club Name</th>
                                <th>Home Stadium</th>
                                <th>League</th>
                                <th>Country</th>
                            </tr>
                            <?php viewClubs() ?>
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
