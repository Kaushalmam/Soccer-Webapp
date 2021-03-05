<?php
if (!isset($activeTab)) {
    $activeTab = 'player';
}
$playerTab = $managerTab = $clubTab = $seasonTab = '';
switch ($activeTab) {
    case 'player':
        $playerTab = 'active';
        break;
    case 'manager':
        $managerTab = 'active';
        break;
    case 'club':
        $clubTab = 'active';
        break;
    case 'season':
        $seasonTab = 'active';
        break;
    default:
        break;
}
?>
<!-- Navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <!-- Include a container inside of our navbar so the container will span the same width of the content -->
    <div class="container">

        <!-- navbar-toggle positions the toggle button over to the right side of the navbar in mobile views. -->
        <!-- Data-toggle attribute is a custom data attribute that calls the collapse JS plugin functions -->
        <!-- Data-target attribute id what makes the nav toggle on and off -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <!-- brand will let bootstrap to place it over to the left side of the navigation. text-muted don't let text stand out -->
            <a class="navbar-brand text-muted" href="Final.html">Golden Goal</a>
        </div>
        <div class="collapse navbar-collapse">

            <!-- navbar positions the navigation links horizontally and gives them their default color styles. -->
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo $playerTab ?> dropdown">
                    <a data-toggle="dropdown" data-target="player.html">Player<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="player.php">Player Information</a></li>
                        <li><a href="playerPerf.php">Player Performance</a></li>
                    </ul>
                </li>

                <li class="<?php echo $managerTab ?> dropdown">
                    <a data-toggle="dropdown" data-target="manager.html">Manager<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="manager.php">Manager Information</a></li>
                        <li><a href="managerPerf.php">Manager Performance</a></li>
                    </ul>
                </li>

                <li class="<?php echo $clubTab ?> dropdown">
                    <a data-toggle="dropdown" data-target="club.html">Club<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="club.php">Club Information</a></li>
                        <li><a href="clubPerf.php">Club Performance</a></li>
                    </ul>
                </li>

                <li class="<?php echo $seasonTab ?> dropdown">
                    <a data-toggle="dropdown" data-target="match.html">Season<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="match.php">Detailed Statistics</a></li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</div>
<!-- End navbar -->
