<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// get all locations

$app->get('/api/locations', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM location";

    try{
        //get db obj
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $locations = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $json = json_encode(array(
            "results" => $locations));
        echo $json;
            //echo json_encode($locations);
    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});