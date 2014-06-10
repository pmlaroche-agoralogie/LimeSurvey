<?php

require_once '../application/libraries/jsonRPCClient.php';
define( 'LS_BASEURL', 'http://mcp.ocd-dbs-france.org/');  // adjust this one to your actual LimeSurvey URL
define( 'LS_USER', 'rpcuser' ); //rpcusermail2@yopmail.com
define( 'LS_PASSWORD', 'jflksb6QZwh' );

// the survey to process
$survey_id=934317;
echo $survey_id;
// instanciate a new client
$myJSONRPCClient = new jsonRPCClient( LS_BASEURL.'/admin/remotecontrol' );

// receive session key
$sessionKey= $myJSONRPCClient->get_session_key( LS_USER, LS_PASSWORD );

// receive all ids and info of groups belonging to a given survey
$groups = $myJSONRPCClient->list_groups( $sessionKey, $survey_id );
print_r($groups, null );


$q = $myJSONRPCClient->list_questions( $sessionKey, $survey_id,4 );
print_r($q, null );

//http://stackoverflow.com/questions/23121669/limesurvey-remotecontrol2-api-any-add-response-php-examples
//get response data from FORM input values
$response_data = array(); 
//foreach ($_POST as $key => $value) {
//  $response_data[$key] = $value;
//}  
$response_data['934317X4X10'] = 'A2';
$response_data['934317X5X11'] = '44';
$response_data['934317X6X12'] = '3';
$response_data['934317X6X13'] = '';
$response_data['934317X6X14'] = 'A1';

$response_data['sid'] = '934317';


$responseadded = $myJSONRPCClient->add_response($sessionKey, $survey_id, $response_data);
// show the reponse code
print_r($responseadded);

// release the session key
$myJSONRPCClient->release_session_key( $sessionKey );

?>