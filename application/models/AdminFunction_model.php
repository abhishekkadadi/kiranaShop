<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminFunction_model extends CI_Model {


	public function seeOrders(){
		//$dateOrders=$_POST['sendDate'];//sortBydate
		$statusSort=$_POST['sortString'];//getStatus
		$limitNumber=$_POST['limitNumber'];
		$start=10 * $limitNumber;

	        $this->db->select('op.*,up.userName,up.userEmail,up.userMobile,up.flatNumber,up.address');
			$this->db->from('orderproduct as op');
			$this->db->join('userprofile as up','up.userId = op.userId');
			$this->db->limit(10,$start);
			$this->db->order_by('orderId','desc');
            if(!empty($statusSort)){
					if (false === strtotime($statusSort)){
							$this->db->where('status',$statusSort);	
						}else{
							$this->db->where('DATE(timestamp)',$statusSort);
						}
			 }//outer if


			             $query=$this->db->get();
			             return $query->result_array();
	}//seeOrders



	public function updateOrderStatus(){
		//$dateOrders=$_POST['sendDate'];//sortBydate
		$orderId=$_POST['orderId'];//getStatus
		$status=$_POST['status'];
		$data=array(
                       'status'=>$status
				);

	                     $this->db->where('orderId',$orderId);
			             $this->db->update('orderproduct',$data);
			             return ($this->db->affected_rows() != 1) ? false : true;
	}//updateOrderStatus
	
	public function getTokenfromId($userId){
					$query=$this->db->get_where('userprofile',array('userId'=>$userId));
					return $query->result_array();
				}//getTokenfromId

}
?>