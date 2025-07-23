<?php
$response = file_get_contents("https://idigue.com/api/projects_api.php");
$response = json_decode($response);
//var_dump($response->data);
class ProjectsService
{
    function __construct() {}
    function getProjects()
    {
        $response = file_get_contents("https://idigue.com/api/projects_api.php");
        $response = json_decode($response);
        $projects = $response->data;
        return $projects;
    }
}
