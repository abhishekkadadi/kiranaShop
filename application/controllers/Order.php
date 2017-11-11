<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {


function InsertOrder(){

	$this->load->model('Order_model');
	 $data=$this->Order_model->InsertOrder();
	 if($data==='orderfailed'){
	
	 		 $userdata['status']=failed_insert();
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 
	 }else if($data){
	 
		$data1=$this->Order_model->getAdminToken();
	      $tokens=array();
	      foreach ($data1 as $key) {
			     if(!empty($key)){
			               $tokens[]=$key['token'];
			               }
	      }
				if(!empty($tokens)){
	     		   	  $data='null';
	                  $message=newOrder();
	                  $notify=push_notify($tokens,$message,$data);   
                  }
	  $userdata['status']=success_insert();
	
          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }else{
	
	 $userdata['status']=failed();
          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }
 //$userdata['status']=success_insert();
     }
     
         public function FetchIndivisualOrder(){

	$this->load->model('Order_model');
	 $data=$this->Order_model->FetchIndivisualOrder();
	

 	if($data)
	 {
	 		 $userdata['status']=success_fetch();
	 		  $userdata['data']=$data;
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 
	 }
	 else 
	 {
	 		 $userdata['status']=failed();
          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }
	}//FetchIndivisualOrder
	
	public function FetchDetailedOrder(){

	$this->load->model('Order_model');
	 $data=$this->Order_model->FetchDetailedOrder();
	

 	if($data)
	 {
	 		 $userdata['status']=success_fetch();
	 		  $userdata['data']=$data;
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 
	 }
	 else 
	 {
	 		 $userdata['status']=failed();
          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }
	}//FetchDetailedOrder
	
	
	public function DeleteOrder(){
		$this->load->model('Order_model');
	 	$data=$this->Order_model->DeleteOrder();
	 	if($data)
	 {
	 		 $userdata['status']=success_delete();
	 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }
	 else 
	 {
	 	  $userdata['status']=failed();
          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
	 }
	}//DeleteOrder


}//controller
?>