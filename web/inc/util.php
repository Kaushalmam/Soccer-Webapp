<?php
/*UTILITY FUNCTIONS*/

/**return the value of a form variable,use for future sanitization and type checks
 * @param $variableName
 * @return string
 */
function getFormData($variableName)
{
    if (isset($_GET[$variableName])) {
        return htmlspecialchars($_GET[$variableName]);
    }
    return '';
}

/**return the value of a request variable, use for future sanitization and type checks
 * @param $variableName
 * @param string $returnType // can be int or string, add other types demand and update code
 * @param null|string $requestType
 * @return object
 */
function getRequestData($variableName, $returnType = 'string', $requestType = null)
{
    $requestVariable = $_REQUEST;
    if ($requestType === 'get') {
        $requestVariable = $_GET;
    }
    if ($requestType === 'post') {
        $requestVariable = $_POST;
    }
    $noRequestData = !isset($requestVariable[$variableName]);
    if ($noRequestData) {
        return null;
    }
    $requestData = $requestVariable[$variableName];
    if ($returnType === 'string') {
        $requestData = (string)trim($requestData);
    }
    if ($returnType === 'int') {
        $requestData = (int)trim($requestData);
    }
    return $requestData;
}

/** display message to user
 * @param $message
 * @param bool $showMessage
 * @return void
 */
function showMessage($message, $showMessage = false)
{
    if ($showMessage) {
        // you can replace this with custom css and js to show a modal for example
        echo "<script> alert('$message') </script>";
    } else {
        print "<div class='jumbotron'><h4>$message</h4></div>";
    }
}
