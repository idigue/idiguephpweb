<?php
class MessagesService
{
    function __construct() {}
  
    function getProjectMessages($pid)
    {
        $response = file_get_contents("https://idigue.com/api/projects_api.php");
        $response = json_decode($response);
        $messages = $response->data;
        return $messages;
    }
}
