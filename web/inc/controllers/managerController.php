<?php
/** FUNCTIONS TO VIEW, ADD, EDIT, REMOVE MANAGERS*/

include 'inc/util.php';
include 'inc/models/managerModel.php';

/** add manager to the database
 * @return null
 */
function addManager()
{
    $addManager = getRequestData('AddManager', 'string', 'post');
    if ($addManager) {
        $ManagerName = getRequestData('AddManagerName');
        $ManagerCountry = getRequestData('AddManagerCountry');
        $ManagerAge = getRequestData('AddManagerAge', 'int');
        $result = addManagerToDatabase($ManagerName, $ManagerCountry, $ManagerAge);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/** modify existing manager
 * @return null
 */
function editManager()
{
    $modifyManager = getRequestData('ModifyManager', 'string', 'post');
    if ($modifyManager) {
        $ManagerName = getRequestData('UpdateManagerName');
        $ManagerCountry = getRequestData('UpdateManagerCountry');
        $ManagerAge = getRequestData('UpdateManagerAge', 'int');
        $result = editManagerInDatabase($ManagerName, $ManagerCountry, $ManagerAge);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/** remove existing manager
 * @return null
 */
function deleteManager()
{
    $deleteManager = getRequestData('DeleteManager', 'string', 'post');
    if ($deleteManager) {
        $ManagerName = getRequestData('DeleteManagerName');
        $result = deleteManagerFromDatabase($ManagerName);
        showMessage($result['message'], $result['result']);
    }
    return null;
}

/**show managers existing in the tadabase
 * @return null
 */
function viewManagers()
{
    $managerName = getRequestData('managername');
    $playerName = getRequestData('playername');
    $managerCountry = getRequestData('managercountry');
    $managerMinAge = getRequestData('managerminage');
    $managerMaxAge = getRequestData('managermaxage');
    $clubName = getRequestData('clubname');
    $page = getRequestData('page');
    $condition = getRequestData('cc', 'string', 'get');
    $filters = [
        'managerName' => $managerName,
        'playerName' => $playerName,
        'managerCountry' => $managerCountry,
        'managerMinAge' => $managerMinAge,
        'managerMaxAge' => $managerMaxAge,
        'clubName' => $clubName,
        'page' => $page,
        'cc' => $condition,
    ];
    $managers = getManagers($filters);
    $noOfManagers = count($managers);
    if ($noOfManagers === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($managers as $manager) {
        print '<tr><td>' . $manager['manager_id'] . '</td>
                  <td>' . $manager['manager_name'] . '</td>
                  <td>' . $manager['age'] . '</td>
                  <td>' . $manager['country'] . '</td></tr>';
    }
    $p = $noOfManagers / 15;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="manager.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>"><?php echo $b . " "; ?></a><?php
    }
    echo "<br>";
    return null;
}

/**show manager statistics
 * @return null
 */
function viewManagerStats()
{
    $managerName = getRequestData('managername');
    $playerName = getRequestData('playername');
    $managerCountry = getRequestData('managercountry');
    $clubName = getRequestData('clubname');
    $managerMinAge = getRequestData('managerminage');
    $managerMaxAge = getRequestData('managermaxage');
    $page = getRequestData('page', 'string', 'get');
    $condition = getRequestData('cc', 'string', 'get');

    $filters = [
        'managerName' => $managerName,
        'playerName' => $playerName,
        'managerCountry' => $managerCountry,
        'clubName' => $clubName,
        'managerMinAge' => $managerMinAge,
        'managerMaxAge' => $managerMaxAge,
        'page' => $page,
        'cc' => $condition,
    ];
    $managers = getManagerStats($filters);
    $noOfManagers = count($managers);
    if ($noOfManagers === 0) {
        showMessage('Search Results: Not Found. Please modify your condition!');
        return null;
    }
    foreach ($managers as $manager) {
        print '<tr><td>' . $manager['manager_id'] . '</td>
                  <td>' . $manager['manager_name'] . '</td>
                  <td>' . $manager['age'] . '</td>
                  <td>' . $manager['country'] . '</td></tr>';
    }
    $p = $noOfManagers / 20;
    $p = ceil($p);

    for ($b = 1; $b <= $p; $b++) {
        ?>
        <a href="managerPerf.php?page=<?php echo $b; ?>&cc=<?php echo $condition; ?>&st=<?php echo $stat; ?>"><?php echo $b . " "; ?></a>
        <?php
    }
    echo "<br>";
    return null;
}
