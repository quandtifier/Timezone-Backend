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

        //$json = json_encode(array("results" => array("geometry" => $locations)));
        $json = array("results" => array(array("geometry" => $locations)));
        $result = json_encode($json);
        //$results = json_encode($result);

        echo $result;
            //echo json_encode($locations);
    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// add single location
$app->post('/api/location/add', function (Request $request, Response $response, array $args) {
    $formatted_address = $request->getParam('formatted_address');
    $lat = $request->getParam('lat');
    $lng = $request->getParam('lng');
    echo $formatted_address;
    $sql = "INSERT INTO location (formatted_address,lat,lng) VALUES 
    (:formatted_address,:lat,:lng)";

    try{
        //get db obj
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':formatted_address', $formatted_address);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);

        $stmt->execute();

        echo '{"success": {"text": "location Added"}';
    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});