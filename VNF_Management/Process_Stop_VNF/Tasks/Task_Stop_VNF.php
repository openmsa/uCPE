<?php
require_once '/opt/fmc_repository/Process/Reference/Common/common.php';

function list_args()
{
	create_var_def('device_id', 'Device');	
	create_var_def('vnfi', 'String');	
	
}


check_mandatory_param('device_id');
check_mandatory_param('vnfi');	

$device_id = substr($context['device_id'], 3);
$object_id = $context['vnfi'];
$micro_service_vars_array = array();
$micro_service_vars_array['object_id']		= $context['vnfi'];
$micro_service_vars_array['action']		    = "stopVNF";

$VNF = array('VNF_instances' => array($object_id => $micro_service_vars_array));


$response = execute_command_and_verify_response($device_id, CMD_UPDATE, $VNF, "UPDATE VNF_instances");
$response = json_decode($response, true);

logToFile(debug_dump($response,"*************************\n"));

if($response['wo_status'] !== ENDED)
{				
	$response = prepare_json_response($response['wo_status'], "Failed to Stop VNF", $context, true);	
	echo $response;
	exit;
}

$response = prepare_json_response($response['wo_status'], "Successfully stopped VNF", $context, true);		
echo $response;


?>

