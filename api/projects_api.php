<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once 'dbcontroller.php'; // Include the database controller
class ProjectProposalAPI
{
    private $db_handle;
    private $baseUrl;

    public function __construct()
    {
        $this->db_handle = new DBController();
        $this->baseUrl = 'https://www.idigue.com';
    }

    public function getApiInfo()
    {
        $this->sendResponse(200, [
            'api_name' => 'Project Proposal REST API',
            'version' => '1.0',
            'base_url' => $this->baseUrl,
            'endpoints' => [
                'GET ' . $this->baseUrl . '/api/projects' => 'Get all proposals',
            ]
        ]);
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        $id = isset($segments[2]) ? (int)$segments[2] : null;

        $action = isset($segments[2]) && !is_numeric($segments[2]) ? $segments[2] : null;
        switch ($method) {
            case 'GET':
                if ($action === 'info') {
                    $this->getApiInfo();
                } elseif ($id) {
                    $this->getProject($id);
                } else {
                    $this->getAllProjects();
                }
                break;
            case 'POST':
                if ($action === 'reset') {
                    // $this->resetProposals();
                } else {
                    // $this->createProposal();
                }
                break;

            default:
                $this->sendResponse(405, ['error' => 'Method not allowed']);
        }
    }

    private function getAllProjects()
    {
        $projects = $this->db_handle->runQuery("SELECT * FROM projects ORDER BY timecreated DESC");

        $this->sendResponse(200, [
            'data' => $projects
        ]);
    }

    private function getProject($id)
    {
        $project = $this->db_handle->runQuery("SELECT * FROM projects WHERE id = " . $id);
        if ($project && count($project) > 0) {
            $this->sendResponse(200, ['data' => $project[0]]);
        } else {
            $this->sendResponse(404, ['error' => 'Project not found']);
        }
    }
    private function sendResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit();
    }
}

// Initialize and handle the request
try {
    $api = new ProjectProposalAPI();
    $api->handleRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error'], JSON_PRETTY_PRINT);
}
