<?php
/** FUNCTIONS TO GET SEASON STATISTICS FROM THE DATABASE*/
include 'connection.php';

/**get players existing in the database
 * filters:- clubName, season, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getMatches($filters = [], $dataLimit = 50)
{
    // Getting the input parameter (user):
    $clubName = $filters['clubName'];
    $season = $filters['season'];
    $page = $filters['page'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';
    if ($page == "" || $page == "1") { // use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }

    if ($clubName) {
        $condition = "where c.club_name like '%$clubName%'";
    }

    if ($season) {
        if ($condition) {
            $condition .= " and s.season_year = '$season'";
        } else {
            $condition = "where s.season_year = '$season'";
        }
    }
    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    }else {
        $limit = " limit " . $dataLimit;
    }
    $query = "SELECT s.season_year, c.club_name, sc.home_win, sc.home_draw, sc.home_defeat, sc.away_win, sc.away_draw, sc.away_defeat
                          from seasonclub sc 
                          inner join season s
                          on sc.season_id = s.season_id
                          inner join club c
                          on sc.club_id = c.club_id " . $condition . $limit;
    return getRecords($query);
}
