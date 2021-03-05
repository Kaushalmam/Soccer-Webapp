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
                        <legend>SEARCH PLAYER</legend>
                        <label for="lplayername">Player Lastname</label>
                        <input type="text" id="playername" name="playername"
                               value="<?php echo getFormData('playername'); ?>">

                        <label for="lcountry">Nationality</label>
                        <input type="text" id="countryname" name="playercountry"
                               value="<?php echo getFormData('playercountry'); ?>">

                        <label for="position">Position</label>
                        <select id="position" name="position"
                                value="<?php echo getFormData('position'); ?>">
                            <option value=""></option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>

                        <label for="lmanagername">Player's Manager</label>
                        <input type="text" id="managername" name="managername"
                               value="<?php echo getFormData('managername'); ?>">

                        <label for="lclubname">Player's Club</label>
                        <input type="text" id="clubname" name="clubname"
                               value="<?php echo getFormData('clubname'); ?>">
                        <hr>

                        <label for="lminage">Minimum Age</label>
                        <input type="text" id="lminage" name="playerminage"
                               value="<?php echo getFormData('playerminage'); ?>">

                        <label for="lmaxage">Maximum Age</label>
                        <input type="text" id="lmax" name="playermaxage"
                               value="<?php echo getFormData('playermaxage'); ?>">

                        <input type="submit" value="Search">
                    </fieldset>
                </form>
            </div>
        </div><!--/.sidebar-offcanvas-->

        <div class="col-xs-12 col-lg-9">

            <div class="jumbotron">
                <form method="post" action="">
                    <?php addPlayer(); ?>
                    <fieldset>
                        <legend>Add a Player:</legend>
                        <label for="lplayername">Player Name</label>
                        <input type="text" id="playername" name="PlayerName"
                               value="<?php echo getFormData('PlayerName'); ?>">

                        <label for="lcountry">Nationality</label>
                        <input type="text" id="countryname" name="PlayerCountry"
                               value="<?php echo getFormData('PlayerCountry'); ?>">

                        <label for="position">Position</label>
                        <select id="position" name="PlayerPosition"
                                value="<?php echo getFormData('PlayerPosition'); ?>">
                            <option value=""></option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>

                        <label for="age">Age</label>
                        <input type="number" id="age" name="PlayerAge"
                               value="<?php echo getFormData('PlayerAge'); ?>">

                        <input type="submit" value="Add Player" name="AddPlayer">

                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php editPlayer(); ?>
                    <fieldset>
                        <legend>Update a Player:</legend>
                        <label for="lplayername">Please enter the player's name you want to update:</label>
                        <input type="text" id="updateplayername" name="UpdatePlayerName"
                               value="<?php echo getFormData('UpdatePlayerName'); ?>">
                        <br>

                        <legend>What do you want to update?</legend>
                        <label for="lcountry">Nationality</label>
                        <input type="text" id="updatecountryname" name="UpdatePlayerCountry"
                               value="<?php echo getFormData('UpdatePlayerCountry'); ?>">

                        <label for="position">Position</label>
                        <select id="updateposition" name="UpdatePlayerPosition"
                                value="<?php echo getFormData('UpdatePlayerPosition'); ?>">
                            <option value=""></option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                        </select>

                        <label for="age">Age</label>
                        <input type="number" id="updateplayerage" name="UpdatePlayerAge"
                               value="<?php echo getFormData('UpdatePlayerAge'); ?>">

                        <input type="submit" value="Update Player" name="ModifyPlayer">
                    </fieldset>
                </form>

                <form method="post" action="">
                    <?php deletePlayer(); ?>
                    <fieldset>
                        <legend>Delete a Player:</legend>
                        <label for="lplayername">Please enter the player's name you want to delete:</label>
                        <input type="text" id="deleteplayername" name="DeletePlayerName"
                               value="<?php echo getFormData('DeletePlayerName'); ?>">

                        <input type="submit" value="Delete Player" name="DeletePlayer">
                    </fieldset>
                </form>

            </div>

            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <form method="get" action="">
                        <table id="t01">
                            <tr>
                                <th>Player ID</th>
                                <th>Player Name</th>
                                <th>Age</th>
                                <th>Position</th>
                                <th>Nationality</th>
                            </tr>
                            <?php viewPlayers(); ?>
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
