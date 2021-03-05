<?php
/** FUNCTIONS VIEW, TO ADD, EDIT, REMOVE CLUBS*/

include 'inc/util.php';
include 'inc/models/clubModel.php';
/**add club to the database
 * @return null
 */
function addClub()
{
    $addClub = getRequestData('AddClub', 'string', 'post');
    if ($addClub) {
        $ClubName = getRequestData('AddClubName');
        $ClubCountry = getRequestData('AddClubCountry');
        $ClubLeague = getRequestData('AddClubLeague');
        $HomeStadium = getRequestData('AddHomeStadium');
        $result = addClubToDatabase($ClubName, $ClubCountry, $ClubLeague, $HomeStadium);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**modify existing club
 * @return null
 */
function editClub()
{
    $modifyClub = getRequestData('ModifyClub', 'string', 'post');
    if ($modifyClub) {
        $ClubName = getRequestData('UpdateClubName');
        $ClubCountry = getRequestData('UpdateClubCountry');
        $ClubLeague = getRequestData('UpdateClubLeague');
        $HomeStadium = getRequestData('UpdateHomeStadium');
        $result = editClubInDatabase($ClubName, $ClubCountry, $ClubLeague, $HomeStadium);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**remove existing club
 * @return null
 */
function deleteClub()
{
    $deleteClub = getRequestData('DeleteClub', 'string', 'post');
    if ($deleteClub) {
        $ClubName = getRequestData('DeleteClubName');
        $result = deleteClubFromDatabase($ClubName);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**show clubs existing in the tadabase
 * @return null
 */
function viewClubs()
{
    // Getting the input parameter (user):
    $clubName = getRequestData('clubname');
    $homeStadium = getRequestData('homestadium');
    $league = getRequestData('league');
    $managerName = getRequestData('managername');
    $playerName = getRequestData('playername');
    $page = getRequestData('page');
    $condition = getRequestData('cc', 'string', 'get');
    $filters = [
        'clubName' => $clubName,
        'homeStadium' => $homeStadium,
        'league' => $league,
        'managerName' => $managerName,
        'playerName' => $playerName,
        'page' => $page,
        'cc' => $condition,
    ];
    $clubs = getClubs($filters);
    $noOfClubs = count($clubs);
    if ($noOfClubs === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($clubs as $club) {
        print '<tr><td>' . $club['club_id'] . '</td>
                  <td>' . $club['club_name'] . '</td>
                  <td>' . $club['home_stadium'] . '</td>
                  <td>' . $club['league'] . '</td>
                  <td>' . $club['country'] . '</td></tr>';
    }
    $p = $noOfClubs / 15;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="club.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>"><?php echo $b . " "; ?></a><?php
    }
    echo "<br>";
    return null;
}

/**show club statistics
 * @return null
 */
function viewClubStats()
{
    // Getting the input parameter (user):
    $clubName = getRequestData('clubname');
    $season = getRequestData('season');
    $page = getRequestData('page', 'string', 'get');
    $condition = getRequestData('cc', 'string', 'get');

    $filters = [
        'clubName' => $clubName,
        'season' => $season,
        'page' => $page,
        'cc' => $condition,
    ];
    $clubs = getClubStats($filters);
    $noOfClubs = count($clubs);
    if ($noOfClubs === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($clubs as $club) {
        print '<tr><td>' . $club['season_year'] . '</td>
                  <td>' . $club['club_name'] . '</td>
                  <td>' . $club['total_win'] . '</td>
                  <td>' . $club['total_draw'] . '</td>
                  <td>' . $club['total_defeat'] . '</td></tr>';
    }
    $p = $noOfClubs / 50;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="clubPerf.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>"><?php echo $b . " "; ?></a>
        <?php
    }
    echo "<br>";
    return null;
}
