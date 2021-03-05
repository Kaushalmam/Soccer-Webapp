<?php
/** FUNCTIONS TO VIEW, ADD, EDIT, REMOVE CLUBS TO AND FROM THE DATABASE*/
include 'connection.php';
/**add club to the database
 * @param $ClubName
 * @param $ClubCountry
 * @param $ClubLeague
 * @param $HomeStadium
 * @return array
 */
function addClubToDatabase($ClubName, $ClubCountry, $ClubLeague, $HomeStadium)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ClubName || !$ClubCountry || !$ClubLeague || !$HomeStadium) {
        $result['message'] = "Please enter all the necessary information";
    } else {
        $values = '';
        if (ctype_digit($ClubName)) {
            $result['message'] = "Please enter a valid string value for club name!";
        } else {
            $tempQuery = "select max(club_id)+1 as ID from club";
            $tuple = getRecords($tempQuery, true);
            $ClubID = $tuple['ID'];
            $values = "$ClubID,'$ClubName'";
        }

        if (ctype_digit($HomeStadium)) {
            $result['message'] = "Please enter a valid string value for club home stadium!";
        } else {
            $values .= ",'$HomeStadium'";
        }
        if (ctype_digit($ClubLeague)) {
            $result['message'] = "Please enter a valid string value for club's league!";
        } else {
            $values .= ",'$ClubLeague'";
        }
        if (ctype_digit($ClubCountry)) {
            $result['message'] = "Please enter a valid string value for club country!";
        } else {
            $values .= ",'$ClubCountry'";
        }
        $clubDataIsInvalid = ctype_digit($ClubName) || ctype_digit($ClubCountry);
        if ($clubDataIsInvalid) {
            $result['message'] = "Please enter valid Club Data !";
        } else {
            $query = "INSERT into club (club_id, club_name, home_stadium, league, country) 
                                VALUES (" . $values . ")";
            if (saveRecord($query)) {
                $result['message'] = "New club record created successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Saving Club Failed';
            }
        }
    }
    return $result;
}

/**modify club in the database
 * @param $ClubName
 * @param $ClubCountry
 * @param $ClubLeague
 * @param $HomeStadium
 * @return array
 */
function editClubInDatabase($ClubName, $ClubCountry, $ClubLeague, $HomeStadium)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ClubName || ctype_digit($ClubName)) {
        $result['message'] = "Please enter a valid club name";
    } else {
        $tempQuery = "SELECT club_id from club where club_name = '$ClubName'";
        $tuple = getRecords($tempQuery, true);
        $ClubID = $tuple['club_id'];

        if (!$ClubID) {
            $result['message'] = "The club you want to update doesn't exist in the database!";
        } else if (!$ClubCountry && !$HomeStadium && !$ClubLeague) {
            $result['message'] = "Please enter updated attribute value. No update occurs!";
        } else if (ctype_digit($ClubCountry)) {
            $result['message'] = "Please enter a valid string value for club's country!";
        } else if (ctype_digit($HomeStadium)) {
            $result['message'] = "Please enter an integer value for club's home stadium!";
        } else if (ctype_digit($ClubLeague)) {
            $result['message'] = "Please enter an integer value for club's league!";
        } else {
            $attribute = null;
            if ($HomeStadium) {
                $attribute = "home_stadium = '" . $HomeStadium . "'";
            }

            if ($ClubLeague) {
                if ($attribute) {
                    $attribute .= ",league = '" . $ClubLeague . "'";
                } else {
                    $attribute = "league = '" . $ClubLeague . "'";
                }
            }

            if ($ClubCountry) {
                if ($attribute) {
                    $attribute .= ",country = '" . $ClubCountry . "'";
                } else {
                    $attribute = "country = '" . $ClubCountry . "'";
                }
            }

            if ($attribute) {
                $query = "UPDATE club SET " . $attribute . " where club_name = '$ClubName'";
                if (saveRecord($query)) {
                    $result['message'] = "Club's record updated successfully!";
                    $result['result'] = true;
                } else {
                    $result['message'] = 'Saving Club Failed';
                }
            }
        }
    }
    return $result;
}

/** remove existing club
 * @param $ClubName
 * @return null
 */
function deleteClubFromDatabase($ClubName)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ClubName || ctype_digit($ClubName)) {
        $result['message'] = "Please enter a valid club name";
    } else {
        $tempQuery = "SELECT club_id from club where club_name = '$ClubName'";
        $tuple = getRecords($tempQuery, true);
        $ClubID = $tuple['club_id'];

        if (!$ClubID) {
            $result['message'] = "The club you want to remove doesn't exist in the database!";
        } else {
            $query = "DELETE from club where club_name = '$ClubName'";
            if (saveRecord($query)) {
                $result['message'] = "Club's record removed successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Removing Club Failed';
            }
        }
    }
    return $result;
}

/**get clubs existing in the database
 * filters:- clubName, homeStadium, league, managerName, playerName, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getClubs($filters = [], $dataLimit = 15)
{
    $clubName = $filters['clubName'];
    $homeStadium = $filters['homeStadium'];
    $league = $filters['league'];
    $managerName = $filters['managerName'];
    $playerName = $filters['playerName'];

    $page = $filters['page'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';
    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }
    if ($clubName) {
        $condition = "where c.club_name like '%$clubName%'";
    }

    if ($homeStadium) {
        if ($condition) {
            $condition .= " and c.home_stadium like '%$homeStadium%'";
        } else {
            $condition = "where c.home_stadium like '%$homeStadium%'";
        }
    }

    if ($league) {
        if ($condition) {
            $condition .= " and c.league = '$league'";
        } else {
            $condition = "where c.league = '$league'";
        }
    }

    if ($managerName) {
        if ($condition) {
            $condition .= " and m.manager_name like '%$managerName%'";
        } else {
            $condition = "where m.manager_name like '%$managerName%'";
        }
    }

    if ($playerName) {
        if ($condition) {
            $condition .= " and p.player_name like '%$playerName%'";
        } else {
            $condition = "where p.player_name like '%$playerName%'";
        }
    }

    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    }else {
        $limit = " limit " . $dataLimit;
    }
    // $testQuery = "SELECT distinct c.club_id, c.club_name, c.home_stadium, c.league, c.country from club c limit " . $dataLimit;
    if (!$managerName && !$playerName) {
        $query = "SELECT distinct c.club_id, c.club_name, c.home_stadium, c.league, c.country from club c " . $condition . $limit;
    } else {
        $query = "SELECT distinct c.club_id, c.club_name, c.home_stadium, c.league, c.country from player p 
                          inner join managerplayer mp on p.player_id = mp.player_id
                          inner join manager m on m.manager_id = mp.manager_id
                          inner join playerclub pc on p.player_id = pc.player_id
                          inner join club c on c.club_id = pc.club_id " . $condition . $limit;
    }
    return getRecords($query);
}

/**get club statistics
 * filters:- clubName, season, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getClubStats($filters = [], $dataLimit = 20)
{
    $clubName = $filters['clubName'];
    $page = $filters['page'];
    $season = $filters['season'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';

    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }
    if (!$clubName && !$season) {
        $condition = "";
    }
    if ($clubName) {
        $condition = "where club_name like '%$clubName%'";
    }
    if ($season) {
        if ($condition) {
            $condition .= " and s.season_year = '$season' group by c.club_name";
        } else {
            $condition = "where s.season_year = '$season' group by c.club_name";
        }
    } else {
        $condition .= " group by s.season_year";
    }

    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    }else {
        $limit = " limit " . $dataLimit;
    }
    $query = "SELECT s.season_year, c.club_name, (sc.home_win+sc.away_win) as total_win, 
                          (sc.home_draw+sc.away_draw) as total_draw, (sc.home_defeat+sc.away_defeat) as total_defeat
                          from seasonclub sc 
                          inner join season s
                          on sc.season_id = s.season_id
                          inner join club c
                          on sc.club_id = c.club_id " . $condition . $limit;
    return getRecords($query);
}
