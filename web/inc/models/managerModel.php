<?php
/** FUNCTIONS TO VIEW, ADD, EDIT, REMOVE MANAGERS TO AND FROM THE DATABASE*/
include 'connection.php';
/**add manager to the database
 * @param $ManagerName
 * @param $ManagerCountry
 * @param $ManagerAge
 * @return array
 */
function addManagerToDatabase($ManagerName, $ManagerCountry, $ManagerAge)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ManagerName || !$ManagerCountry || !$ManagerAge) {
        $result['message'] = "Please enter all the necessary information";
    } else {
        $values = '';
        if (ctype_digit($ManagerName)) {
            $result['message'] = "Please enter a valid string value for manager name!";
        } else {
            $tempQuery = "select max(manager_id)+1 as ID from manager";
            $tuple = getRecords($tempQuery, true);
            $ManagerID = $tuple['ID'];
            $values = "$ManagerID,'$ManagerName'";
        }

        if (is_int($ManagerAge)) {
            if ($ManagerAge >= 20 && $ManagerAge <= 75) {
                $values .= ",$ManagerAge";
            } else {
                $result['message'] = "Please enter an valid integer value between 20 and 75 inclusive for manager age";
            }
        } else {
            $result['message'] = "Please enter an valid integer value between 20 and 75 inclusive for manager age";
        }

        if (ctype_digit($ManagerCountry)) {
            $result['message'] = "Please enter a valid string value for manager's country!";
        } else {
            $values .= ",'$ManagerCountry'";
        }
        $managerDataIsInvalid = ctype_digit($ManagerName) || !is_int($ManagerAge) || ctype_digit($ManagerCountry) || $ManagerAge < 20 || $ManagerAge > 75;
        if ($managerDataIsInvalid) {
            $result['message'] = "Please enter valid Manager Data !";
        } else {
            $query = "INSERT into manager (manager_id, manager_name, age, country) 
                                VALUES (" . $values . ")";
            if (saveRecord($query)) {
                $result['message'] = "New manager record created successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Saving Manager Failed';
            }
        }
    }

    return $result;
}

/**modify manager in the database
 * @param $ManagerName
 * @param $ManagerCountry
 * @param $ManagerAge
 * @return array
 */
function editManagerInDatabase($ManagerName, $ManagerCountry, $ManagerAge)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ManagerName || ctype_digit($ManagerName)) {
        $result['message'] = "Please enter a valid manager name";
    } else {
        $tempQuery = "SELECT manager_id from manager where manager_name = '$ManagerName'";
        $tuple = getRecords($tempQuery, true);
        $ManagerID = $tuple['manager_id'];

        if (!$ManagerID) {
            $result['message'] = "The manager you want to update doesn't exist in the database!";
        } else if (!$ManagerCountry && !$ManagerAge) {
            $result['message'] = "Please enter updated attribute value. No update occurs!";
        } else if (ctype_digit($ManagerCountry)) {
            $result['message'] = "Please enter a valid string value for manager's country!";
        } else if (!is_int($ManagerAge)) {
            $result['message'] = "Please enter an integer value for manager's age!";
        } else {
            $attribute = null;
            if ($ManagerCountry) {
                $attribute = "country = '" . $ManagerCountry . "'";
            }
            if ($ManagerAge) {
                if ($ManagerAge >= 20 && $ManagerAge <= 75) {
                    if ($attribute) {
                        $attribute .= ",age = " . $ManagerAge;
                    } else {
                        $attribute = "age = " . $ManagerAge;
                    }
                } else {
                    $result['message'] = "Please enter an valid integer value between 20 and 75 inclusive for manager age";
                }

            }

            if ($attribute) {
                $query = "UPDATE manager SET " . $attribute . " where manager_name = '$ManagerName'";
                if (saveRecord($query)) {
                    $result['message'] = "Manager's record updated successfully!";
                    $result['result'] = true;
                } else {
                    $result['message'] = 'Saving Manager Failed';
                }
            }
        }
    }
    return $result;
}

/**remove existing manager
 * @param $ManagerName
 * @return null
 */
function deleteManagerFromDatabase($ManagerName)
{
    $result = ['result' => false, 'message' => ''];
    if (!$ManagerName || ctype_digit($ManagerName)) {
        $result['message'] = "Please enter a valid manager name";
    } else {
        $tempQuery = "SELECT manager_id from manager where manager_name = '$ManagerName'";
        $tuple = getRecords($tempQuery, true);
        $ManagerID = $tuple['manager_id'];

        if (!$ManagerID) {
            $result['message'] = "The manager you want to remove doesn't exist in the database!";
        } else {
            $query = "DELETE from manager where manager_name = '$ManagerName'";
            if (saveRecord($query)) {
                $result['message'] = "Manager's record removed successfully!";
                $result['result'] = true;
            } else {
                $result['message'] = 'Removing Manager Failed';
            }
        }
    }
    return $result;
}

/**get managers existing in the database
 * filters:- managerName, managerCountry, managerName, clubName, managerMinAge, managerMaxAge, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getManagers($filters = [], $dataLimit = 15)
{
    // Getting the input parameter (user):
    $managerName = $filters['managerName'];
    $playerName = $filters['playerName'];
    $managerCountry = $filters['managerCountry'];
    $clubName = $filters['clubName'];
    $managerMinAge = $filters['managerMinAge'];
    $managerMaxAge = $filters['managerMaxAge'];
    $page = $filters['page'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';
    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }

    if ($managerName) {
        $condition = "where m.manager_name like '%$managerName%'";
    }

    if ($managerCountry) {
        if ($condition) {
            $condition .= " and m.country like '%$managerCountry%'";
        } else {
            $condition = "where m.country like '%$managerCountry%'";
        }
    }

    if ($playerName) {
        if ($condition) {
            $condition .= " and p.player_name like '%$playerName%'";
        } else {
            $condition = "where p.player_name like '%$playerName%'";
        }
    }

    if ($clubName) {
        if ($condition) {
            $condition .= " and c.club_name like '%$clubName%'";
        } else {
            $condition = "where c.club_name like '%$clubName%'";
        }
    }

    if ($managerMinAge) {
        if ($condition) {
            $condition .= " and m.age >= '$managerMinAge'";
        } else {
            $condition = "where m.age >= '$managerMinAge'";
        }
    }

    if ($managerMaxAge) {
        if ($condition) {
            $condition .= " and m.age <= '$managerMaxAge'";
        } else {
            $condition = "where m.age <= '$managerMaxAge'";
        }
    }
    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    } else {
        $limit = " limit " . $dataLimit;
    }
    // $testQuery = "SELECT m.manager_id, m.manager_name, m.age, m.country FROM manager m limit " . $dataLimit;
    if (!$managerName && !$clubName) {
        $query = "SELECT m.manager_id, m.manager_name, m.age, m.country FROM manager m " . $condition . $limit;
    } else {
        $query = "SELECT distinct m.manager_id, m.manager_name, m.age, m.country FROM manager m
                          inner join managerplayer mp on m.manager_id = mp.manager_id
                          inner join player p on p.player_id = mp.player_id
                          inner join playerclub pc on p.player_id = pc.player_id 
                          inner join club c on c.club_id = pc.club_id " . $condition . $limit;
    }
    return getRecords($query);
}

/** get manager statistics
 * filters:- managerName, managerCountry, managerName, clubName, managerMinAge, managerMaxAge, page, cc
 * @param array $filters
 * @param int $dataLimit
 * @return array
 */
function getManagerStats($filters = [], $dataLimit = 15)
{
    // Getting the input parameter (user):
    $managerName = $filters['managerName'];
    $playerName = $filters['playerName'];
    $managerCountry = $filters['managerCountry'];
    $clubName = $filters['clubName'];
    $managerMinAge = $filters['managerMinAge'];
    $managerMaxAge = $filters['managerMaxAge'];
    $page = $filters['page'];
    $condition = isset($filters['cc']) ? $filters['cc'] : '';
    if ($page == "" || $page == "1") {// use weak type checking here
        $page1 = 0;
    } else {
        $page1 = ($page * $dataLimit) - $dataLimit;
    }

    if ($managerName) {
        $condition = "where m.manager_name like '%$managerName%'";
    }

    if ($managerCountry) {
        if ($condition) {
            $condition .= " and m.country like '%$managerCountry%'";
        } else {
            $condition = "where m.country like '%$managerCountry%'";
        }
    }

    if ($playerName) {
        if ($condition) {
            $condition .= " and p.player_name like '%$playerName%'";
        } else {
            $condition = "where p.player_name like '%$playerName%'";
        }
    }

    if ($clubName) {
        if ($condition) {
            $condition .= " and c.club_name like '%$clubName%'";
        } else {
            $condition = "where c.club_name like '%$clubName%'";
        }
    }

    if ($managerMinAge) {
        if ($condition) {
            $condition .= " and m.age >= '$managerMinAge'";
        } else {
            $condition = "where m.age >= '$managerMinAge'";
        }
    }

    if ($managerMaxAge) {
        if ($condition) {
            $condition .= " and m.age <= '$managerMaxAge'";
        } else {
            $condition = "where m.age <= '$managerMaxAge'";
        }
    }
    $limit = "";
    if ($page1) {
        $limit = " limit $page1, " . $dataLimit;
    } else {
        $limit = " limit " . $dataLimit;
    }
    $query = "SELECT distinct m.manager_id, m.manager_name, m.age, m.country FROM manager m
                          inner join managerplayer mp on m.manager_id = mp.manager_id
                          inner join player p on p.player_id = mp.player_id
                          inner join playerclub pc on p.player_id = pc.player_id 
                          inner join club c on c.club_id = pc.club_id " . $condition . $limit;
    return getRecords($query);
}
