<?php 
namespace Controllers\Website\Seniman;
$rootDir = dirname(dirname(dirname(__DIR__)));
// require_once ''
use Database\Database;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class TempatDashboardController{
    private static $database;
    private static $con;
    private static $url;
    public function __construct(){
        if(!isset($_SERVER['TEMPAT_PORT']) ||is_null($_SERVER['TEMPAT_PORT']) || empty($_SERVER['TEMPAT_PORT'])){
            self::$url = $_SERVER['TEMPAT_URL'];
        }else{
            self::$url = $_SERVER['TEMPAT_URL'].':'.$_SERVER['TEMPAT_PORT'];
        }
        self::$database = Database::getInstance();
        self::$con = self::$database->getConnection();
    }
    public function show($data,$uri = null){
        $client = new Client();
        try{
            $response = $client->get(self::$url.'/dashboard');
            $body = $response->getBody();
            return json_decode($body,true);
        }catch(RequestException $e){
            $error = $e->getMessage();
            $erorr = json_decode($error, true);
            if ($erorr === null) {
                $responseData = array(
                    'status' => 'error',
                    'message' => $error,
                );
            }else{
                if($erorr['message']){
                    $responseData = array(
                        'status' => 'error',
                        'message' => $erorr['message'],
                    );
                }else{
                    $responseData = array(
                        'status' => 'error',
                        'message' => $erorr->message,
                    );
                }
            }
            return $responseData;
        }
    }
}
?>