<?php
/** FUNCTIONS TO VIEW, ADD, EDIT, REMOVE PLAYERS TO AND FROM THE DATABASE*/
include 'connection.php';
/**add player to the database
 * @param $PlayerName
 * @param $PlayerCountry
 * @param $PlayerPosition
 * @param $PlayerAge
 * @return array
 */
function addPlayerToDatabase($PlayerName, $PlayerCountry, $PlayerPosition, $PlayerAge)
{
    $result = ['result' => false, 'message' => ''];
    if (!$PlayerName || !$PlayerCountry || !$PlayerPosition || !$PlayerAge) {
        $result['message'] = "Please enter all the necessary information";
    } else {
        $values = '';
        if (ctype_digit($PlayerName)) {
            $result['message'] = "Please enter a valid string value for player name!";
        } else {
            $tempQuery = "select max(player_id)+1 as ID from player";
            $tuple = getRecords($tempQuery, true);
            $PlayerID = $tuple['ID'];
            $values = "$PlayerID,'$PlayerName'";
        }

        if (is_int($PlayerAge) && $PlayerAge >= 15 && $PlayerAge <= 40) {
            $values .= ",$PlayerAge,'$PlayerPosition'";
        } else {
            $result['message'] = "Please enter an valid integer value between 15 and 40 inclusive for player age";
        }

        if (ctype_digit($PlayerCountry)) {
            $result['message'] = "Please enter a valid string value for player country!";
        } else {
            $values .= ",'$PlayerCountry'";
        }
        $playerDataIsInvalid = ctype_digit($PlayerName) || !is_int($PlayerAge) || ctype_digit($PlayerCountry) || ($PlayerAge < 15 || $PlayerAge > 40);
        if ($playerDataIsInvalid) {
            $result['message'] = "Please enter valid Player Data !";
        } else {
            $query = "INSERT into player (player_id, player_name, age, position, country) 
                                VALUES (" . $values . ")";
            if (saveRecord($query)) {
                $result['message'] = "New player record created successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Saving Player Failed';
            }
        }
    }
    return $result;
}

/**modify player in the database
 * @param $PlayerName
 * @param $PlayerCountry
 * @param $PlayerPosition
 * @param $PlayerAge
 * @return array
 */
function editPlayerInDatabase($PlayerName, $PlayerCountry, $PlayerPosition, $PlayerAge)
{
    $result = ['result' => false, 'message' => ''];
    if (!$PlayerName || ctype_digit($PlayerName)) {
        $result['message'] = "Please enter a valid player name";
    } else {
        $tempQuery = "SELECT player_id from player where player_name = '$PlayerName'";
        $tuple = getRecords($tempQuery, true);
        $PlayerID = $tuple['player_id'];

        if (!$PlayerID) {
            $result['message'] = "The player you want to update doesn't exist in the database!";
        } else if (!$PlayerCountry && !$PlayerPosition && !$PlayerAge) {
            $result['message'] = "Please enter updated attribute value. No update occurs!";
        } else if (ctype_digit($PlayerCountry)) {
            $result['message'] = "Please enter a valid string value for player's country!";
        } else if (!is_int($PlayerAge)) {
            $result['message'] = "Please enter an integer value for player's age!";
        } else {
            $attribute = null;
            if ($PlayerCountry) {
                $attribute = "country = '" . $PlayerCountry . "'";
            }
            if ($PlayerPosition) {
                if ($attribute) {
                    $attribute .= ",position = '" . $PlayerPosition . "'";
                } else {
                    $attribute = "position = '" . $PlayerPosition . "'";
                }
            }
            if ($PlayerAge) {
                if ($PlayerAge >= 15 && $PlayerAge <= 40) {
                    if ($attribute) {
                        $attribute .= ",age = " . $PlayerAge;
                    } else {
                        $attribute = "age = " . $PlayerAge;
                    }
                } else {
                    $result['message'] = "Please enter an valid integer value between 15 and 40 inclusive for player age";
                }

            }

            if ($attribute) {
                $query = "UPDATE player SET " . $attribute . " where player_name = '$PlayerName'";
                if (saveRecord($query)) {
                    $result['message'] = "Player's record updated successfully!";
                    $result['result'] = true;
                } else {
                    $result['message'] = 'Saving Player Failed';
                }
            }
        }
    }
    return $result;
}

/**remove existing player
 * @param $PlayerName
 * @return null
 */
function deletePlayerFromDatabase($PlayerName)
{
    $result = ['result' => false, 'message' => ''];
    if (!$PlayerName || ctype_digit($PlayerName)) {
        $result['message'] = "Please enter a valid player name";
    } else {
        $tempQuery = "SELECT player_id from player where player_name = '$PlayerName'";
        $tuple = getRecords($tempQuery, true);
        $PlayerID = $tuple['player_id'];

        if (!$PlayerID) {
            $result['message'] = "The player you want to remove doesn't exist in the database!";
        } else {
            $query = "DELETE from player where player_name = '$PlayerName'";
            if (saveRecord($query)) {
                $result['message'] = "Player's record removed successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Removing Player Failed';
            }
        }
    }
    return $result;
}

/**get players existing in the database
 * filters:- playerName, playerCountry, position, managerName, clubName, playerMinAge, playerMaxAge, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getPlayers($filters = [], $dataLimit = 50)
{
    // Getting the input parameter (user):
    $playerName = $filters['playerName'];
    $playerCountry = $filters['playerCountry'];
    $position = $filters['position'];
    $managerName = $filters['managerName'];
    $clubName = $filters['clubName'];
    $playerMinAge = $filters['playerMinAge'];
    $playerMaxAge = $filters['playerMaxAge'];
    $page = $filters['page'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';
    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }

    if ($playerName) {
        $condition = "where p.player_name like '%$playerName%'";
    }

    if ($playerCountry) {
        if ($condition) {
            // you can make this equal sign comparison if you use selection boxes on client side
            $condition .= " and p.country like '%$playerCountry%'";
        } else {
            $condition = "where p.country like '%$playerCountry%'";
        }
    }

    if ($position) {
        if ($condition) {
            $condition .= " and p.position = '$position'";
        } else {
            $condition = "where p.position = '$position'";
        }
    }

    if ($managerName) {
        if ($condition) {
            $condition .= " and m.manager_name like '%$managerName%'";
        } else {
            $condition = "where m.manager_name like '%$managerName%'";
        }
    }

    if ($clubName) {
        if ($condition) {
            $condition .= " and c.club_name like '%$clubName%'";
        } else {
            $condition = "where c.club_name like '%$clubName%'";
        }
    }

    if ($playerMinAge) {
        if ($condition) {
            $condition .= " and p.age >= '$playerMinAge'";
        } else {
            $condition = "where p.age >= '$playerMinAge'";
        }
    }

    if ($playerMaxAge) {
        if ($condition) {
            $condition .= " and p.age <= '$playerMaxAge'";
        } else {
            $condition = "where p.age <= '$playerMaxAge'";
        }
    }
    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    } else {
        $limit = " limit " . $dataLimit;
    }
    // $testQuery = "SELECT p.player_id, p.player_name, p.age, p.position, p.country FROM player p limit 30, " . $dataLimit;
    if (!$managerName && !$clubName) {
        $query = "SELECT p.player_id, p.player_name, p.age, p.position, p.country FROM player p " . $condition . $limit;
    } else {
        $query = "SELECT p.player_id, p.player_name, p.age, p.position, p.country FROM player p 
                          inner join managerplayer mp on p.player_id = mp.player_id 
                          inner join manager m on m.manager_id = mp.manager_id 
                          inner join playerclub pc on p.player_id = pc.player_id 
                          inner join club c on c.club_id = pc.club_id " . $condition . $limit;
    }
    return getRecords($query);
}

/** get player statistics
 * filters:- clubName,page, stat, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getPlayerStats($filters = [], $dataLimit = 20)
{
    // Getting the input parameter (user):
    $clubName = $filters['clubName'];
    $page = $filters['page'];
    $stat = $filters['stat'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';

    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }
    if ($clubName) {
        $condition = "where club_name like '%$clubName%'";
    }

    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    } else {
        $limit = " limit " . $dataLimit;
    }
    $query = "SELECT club_name, player_name, count(goal_id) as stat
                          from player p
                          inner join goalscore gs
                          on p.player_id = gs.player_id
                          inner join playerclub pc
                          on p.player_id = pc.player_id
                          inner join club c
                          on pc.club_id = c.club_id " . $condition . "group by player_name" . $limit;
    if ($stat === 'card') {
        $query = "SELECT club_name, player_name, count(card_type) as stat
                          from player p
                          inner join card ca
                          on p.player_id = ca.player_id
                          inner join playerclub pc
                          on p.player_id = pc.player_id
                          inner join club c
                          on pc.club_id = c.club_id " . $condition . "group by player_name" . $limit;
    } else if ($stat === 'assist') {
        $query = "SELECT club_name, player_name, count(assist_id) as stat
                          from player p
                          inner join assist a
                          on p.player_id = a.player_id
                          inner join playerclub pc
                          on p.player_id = pc.player_id
                          inner join club c
                          on pc.club_id = c.club_id " . $condition . "group by player_name" . $limit;
    }

    return getRecords($query);
}
