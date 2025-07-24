<?php
$response = file_get_contents("https://idigue.com/api/products_api.php");
$response = json_decode($response);
//var_dump($response->data);
class ProjectsService
{
    function __construct() {}
    function getProducts()
    {
        $response = file_get_contents("https://idigue.com/api/products_api.php");
        $response = json_decode($response);
        $projects = $response->data;
        return $projects;
    }
    function getProduct($id)
    {
        $response = file_get_contents("https://idigue.com/api/products_api.php");
        $response = json_decode($response);
        $products = $response->data;
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->id == $id) {
                return $products[$i];
            }
        }
        return $products[0];
    }
}
