<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminFunction extends CI_Controller {

	public function seeOrders(){

	$this->load->model('AdminFunction_model');
	$data=$this->AdminFunction_model->seeOrders();

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
	}//seeOrders
	
	public function updateOrderStatus(){
		$userId=$_POST['userId'];
		$this->load->model('AdminFunction_model');
		$data=$this->AdminFunction_model->updateOrderStatus();
		 	if($data)
			 {       
			 	      $data2=$this->AdminFunction_model->getTokenfromId($userId);
				      $tokens=array();
				      foreach ($data2 as $key) {
						     if(!empty($key)){
						               $tokens[]=$key['token'];
						               }
	      				}
						if(!empty($tokens)){
			     		   	  $data='null';
			                  $message=statusChanged();
			                  $notify=push_notify($tokens,$message,$data);   
		                  }

			 		 $userdata['status']=success_update();
			 		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
			 }
			 else 
			 {
			 	  $userdata['status']=failed();
		          $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
			 }
	}//updateOrderStatus


}//adminfunction
?>