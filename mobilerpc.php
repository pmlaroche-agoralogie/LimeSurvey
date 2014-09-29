<?php
// add one answer to a questionnaire 

// reference : http://manual.limesurvey.org/RemoteControl_2_API#add_response
// http://stackoverflow.com/questions/23121669/limesurvey-remotecontrol2-api-any-add-response-php-examples

// in case of problem, log everything !
file_put_contents('logs/_CHANGETHIS_'.time().'-'.rand(100000,900000).'txt',$_SERVER['REQUEST_URI']);

if(!isset($_GET['answer']))die();

require_once '../application/libraries/jsonRPCClient.php';
require_once 'rcp_parameters.php';

//get response data from POST input values
$response_data = array();
$jsonparameter = json_decode($_GET['answer']);
foreach ($jsonparameter as $key => $value) {
 $response_data[$key] = $value;
}

// the survey to process
$survey_id= $response_data['sid'];

// instanciate a new client
$myJSONRPCClient = new jsonRPCClient( LS_BASEURL.'/admin/remotecontrol' );

// receive session key
$sessionKey= $myJSONRPCClient->get_session_key( LS_USER, LS_PASSWORD );

date_default_timezone_set('Europe/Paris');
$response_data['submitdate'] = date('Y-m-d H:i:s',$jsonparameter->timestamp);

$responseadded = $myJSONRPCClient->add_response($sessionKey, $survey_id, $response_data);
// show the reponse code
if(is_numeric($responseadded))
    {
        echo "1"; // $responseadded value is the id of recorded answer
    }
    else
    {
        echo "0"; // $responseadded value is an array with error explaination
    }

// release the session key
$myJSONRPCClient->release_session_key( $sessionKey );
?>