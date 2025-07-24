<?php
class ProjectProposalsService
{
    function __construct() {}
  
    function getProjectProposals($pid)
    {
        $response = file_get_contents("https://idigue.com/api/projects_proposals_api.php");
        $response = json_decode($response);
        $proposals = $response->data;
        return $proposals;
    }
}
