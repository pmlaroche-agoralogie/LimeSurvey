<?php

// http://mcp.ocd-dbs-france.org/test/testrpcpl.php?answer={%22366836X99X43%22:%22A2%22,%22366836X106X105%22:%22A2%22,%22366836X101X116%22:%2254%22,%22sid%22:%22%20366836%22}

if(!isset($_GET['answer']))die();

require_once '../application/libraries/jsonRPCClient.php';


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

/*
// receive all ids and info of groups belonging to a given survey
$groups = $myJSONRPCClient->list_groups( $sessionKey, $survey_id );
print_r($groups, null );
echo "<br>";

$q = $myJSONRPCClient->list_questions( $sessionKey, $survey_id,99 );
print_r($q, null );
echo "<br>";
*/

//http://stackoverflow.com/questions/23121669/limesurvey-remotecontrol2-api-any-add-response-php-examples
//get response data from FORM input values


$responseadded = $myJSONRPCClient->add_response($sessionKey, $survey_id, $response_data);
// show the reponse code
if(is_int($responseadded))
    echo "1"; // $responseadded value is the id of recorded answer
    else
    echo "0"; // array with error explaination

// release the session key
$myJSONRPCClient->release_session_key( $sessionKey );

?>