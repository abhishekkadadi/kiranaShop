<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 function success_insert(){
	$status=1;
	return array('status'=>$status,'message'=>'Successfully Data inserted...');
	
}

 function failed_insert(){
	$status='-1';
	return array('status'=>$status,'message'=>'Failed to insert data...');
	
}

function email_present(){
	$status=0;
	return array('status'=>$status,'message'=>'Sorry...Email already Exists!');
	
}

function failed(){
	$status=0;
	return array('status'=>$status,'message'=>'Oops! something went wrong');
	
}

function login_failed(){
	$status=0;
	return array('status'=>$status,'message'=>'Invalid credential..!');
	
}

function success_fetch(){
	$status=1;
	return array('status'=>$status,'message'=>'Successfully fetched...');
	
}

function success_update(){
	$status=1;
	return array('status'=>$status,'message'=>'Order updated successfully...');
	
}
function success_delete(){
	$status=1;
	return array('status'=>$status,'message'=>'Order deleted successfully...');
}


function mail_sent(){
	$status=1;
	return array('status'=>$status,'message'=>'Mail sent');
}

function mail_failed(){
	$status=0;
	return array('status'=>$status,'message'=>'Mail sending failed');
}

function nodata_fetch(){
	$status=-1;
	return array('status'=>$status,'message'=>'Email not found');
}

?>