<?php
/** FUNCTIONS TO VIEW, ADD, EDIT, REMOVE PLAYERS*/

include 'inc/util.php';
include 'inc/models/playerModel.php';

/**add player to the database
 * @return null
 */
function addPlayer()
{
    $addPlayer = getRequestData('AddPlayer', 'string', 'post');
    if ($addPlayer) {
        $PlayerName = getRequestData('PlayerName');
        $PlayerCountry = getRequestData('PlayerCountry');
        $PlayerPosition = getRequestData('PlayerPosition');
        $PlayerAge = getRequestData('PlayerAge', 'int');
        $result = addPlayerToDatabase($PlayerName, $PlayerCountry, $PlayerPosition, $PlayerAge);
        showMessage($result['message'], $result['result']);
    }
    // return null;
}

/**modify existing player
 * @return null
 */
function editPlayer()
{
    $modifyPlayer = getRequestData('ModifyPlayer', 'string', 'post');
    if ($modifyPlayer) {
        $PlayerName = getRequestData('UpdatePlayerName');
        $PlayerCountry = getRequestData('UpdatePlayerCountry');
        $PlayerPosition = getRequestData('UpdatePlayerPosition');
        $PlayerAge = getRequestData('UpdatePlayerAge', 'int');
        $result = editPlayerInDatabase($PlayerName, $PlayerCountry, $PlayerPosition, $PlayerAge);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**remove existing player
 * @return null
 */
function deletePlayer()
{
    $deletePlayer = getRequestData('DeletePlayer', 'string', 'post');
    if ($deletePlayer) {
        $PlayerName = getRequestData('DeletePlayerName');
        $result = deletePlayerFromDatabase($PlayerName);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**show players existing in the tadabase
 * @return null
 */
function viewPlayers()
{
    // Getting the input parameter (user):
    $playerName = getRequestData('playername');
    $playerCountry = getRequestData('playercountry');
    $position = getRequestData('position');
    $managerName = getRequestData('managername');
    $clubName = getRequestData('clubname');
    $playerMinAge = getRequestData('playerminage');
    $playerMaxAge = getRequestData('playermaxage');
    $page = getRequestData('page');
    $condition = getRequestData('cc', 'string', 'get');
    $filters = [
        'playerName' => $playerName,
        'playerCountry' => $playerCountry,
        'position' => $position,
        'managerName' => $managerName,
        'clubName' => $clubName,
        'playerMinAge' => $playerMinAge,
        'playerMaxAge' => $playerMaxAge,
        'page' => $page,
        'cc' => $condition,
    ];
    $players = getPlayers($filters);
    $noOfPlayers = count($players);
    if ($noOfPlayers === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($players as $player) {
        print '<tr><td>' . $player['player_id'] . '</td>
                  <td>' . $player['player_name'] . '</td>
                  <td>' . $player['age'] . '</td>
                  <td>' . $player['position'] . '</td>
                  <td>' . $player['country'] . '</td></tr>';
    }
    $p = $noOfPlayers / 50;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="player.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>"><?php echo $b . " "; ?></a><?php
    }
    echo "<br>";
    return null;
}

/**show player statistics
 * @return null
 */
function viewPlayerStats()
{
    // Getting the input parameter (user):
    $clubName = getRequestData('clubname');
    $stat = getRequestData('stat');
    if (!$stat) {
        $stat = getRequestData("st");
    }
    $page = getRequestData('page', 'string', 'get');
    $condition = getRequestData('cc', 'string', 'get');

    $filters = [
        'clubName' => $clubName,
        'page' => $page,
        'stat' => $stat,
        'cc' => $condition,
    ];
    $players = getPlayerStats($filters);
    $noOfPlayers = count($players);
    if ($noOfPlayers === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($players as $player) {
        print '<tr><td>' . $player['club_name'] . '</td>
                  <td>' . $player['player_name'] . '</td>
                  <td>' . $player['stat'] . '</td></tr>';
    }
    $p = $noOfPlayers / 20;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a
        href="playerPerf.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>&st=<?php echo $stat; ?>"><?php echo $b . " "; ?></a><?php
    }
    echo "<br>";
    return null;
}
