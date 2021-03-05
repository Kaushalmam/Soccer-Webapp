<?php
/** FUNCTIONS VIEW SEASON STATISTICS*/

include 'inc/util.php';
include 'inc/models/matchModel.php';

/**show season statistics
 * @return null
 */
function viewMatches()
{
    // Getting the input parameter (user):
    $clubName = getRequestData('clubname');
    $season = getRequestData('season');
    $page = getRequestData('page');
    $condition = getRequestData('cc', 'string', 'get');
    $filters = [
        'clubName' => $clubName,
        'season' => $season,
        'page' => $page,
        'cc' => $condition,
    ];
    $seasons = getMatches($filters);
    $noOfSeasons = count($seasons);
    if ($noOfSeasons === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($seasons as $season) {
        print '<tr><td>' . $season['season_year'] . '</td>
                  <td>' . $season['club_name'] . '</td>
                  <td>' . $season['home_win'] . '</td>
                  <td>' . $season['home_draw'] . '</td>
                  <td>' . $season['home_defeat'] . '</td>
                  <td>' . $season['away_win'] . '</td>
                  <td>' . $season['away_draw'] . '</td>
                  <td>' . $season['away_defeat'] . '</td></tr>';
    }
    $p = $noOfSeasons / 50;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="match.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>"><?php echo $b . " "; ?></a>
        <?php
    }
    echo "<br>";
    return null;
}
