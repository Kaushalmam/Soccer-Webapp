<?php
/** HANDLE ALL DATABASE OPERATIONS */
define('DB_SERVER', 'localhost');
define('DB_NAME', 'goldengoal');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** get database connection
 * @return mysqli
 */
function getDbConnection()
{
    // Create connection
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    // Check connection
    $connectionError = $connection->connect_error;
    if ($connectionError) {
        logMessage("Connection failed: " . $connectionError);
        die();
    }

    // logMessage("Connected successfully");
    return $connection;
}

/** execute database query
 * @param $queryString
 * @return bool|mysqli_result
 */
function executeQuery($queryString)
{
    $connection = getDbConnection();
    try {
        return mysqli_query($connection, $queryString);
    } catch (Exception $exception) {
        logMessage($exception);
        die('Query failed: ' . mysqli_error($connection));
    }
}

/** retrieve database records
 * @param $queryString
 * @param bool $getOneRecord
 * @return array
 */
function getRecords($queryString, $getOneRecord = false)
{
    $result = executeQuery($queryString);
    if (!$result) {
        return [];
    }
    if ($getOneRecord) {
        return mysqli_fetch_assoc($result);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/** add, update or delete database record
 * @param $queryString
 * @return bool
 */
function saveRecord($queryString)
{
    $result = executeQuery($queryString);
    if (!$result) {
        return false;
    }
    return true;
}

/** send client side error messages to admin
 * @param $msg // message object
 */
function logMessage($msg)
{
    $time = date("F jS Y, H:i", time() + 25200);
    $file = 'errors.txt';
    $open = fopen($file, 'ab');
    fwrite($open, $time . '  :  ' . json_encode($msg) . "\r\n");
    fclose($open);
}
