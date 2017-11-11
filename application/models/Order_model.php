<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model {


	function InsertOrder(){
	
		$finalproductarray = array();

		     $userId = $_POST['userId'];
		     $amount = $_POST['amount'];
		     $comment = $_POST['comment'];
		     //for cart
		     $productarray = $_POST['product'];

		    $parray= json_decode($productarray, true);
		   




		   
		$data=array(
										  	'userId'=> $userId,
										  	'amount'=> $amount,
										   	'comment'=> $comment
										    		
						    				);
				        			
								    $this->db->insert('orderproduct', $data);
								    $orderId = $this->db->insert_id();

 foreach ($parray as $key)
		     {
		    
		    $data_array= array(
		    	'productId'=> $key['productId'],
		    	'productUnit'=> $key['productUnit'],
		    	'productPrice'=> $key['productPrice'],
		    	'productQty'=> $key['productQty'],
		    	'orderId'=> $orderId
		    	);
		    $finalproductarray[] = $data_array;
		    }
									if($this->db->affected_rows() == 1)
									{

										 $InsertCart=$this->insertCart($finalproductarray);
										 if($InsertCart)
										 {
										 	//return true;
										 	 return $InsertCart;
										 }
										 else
										 {
										 	return false;

										 }

									}
									else
									{
										return 'orderfailed';
									} 


	}//InsertOrder



	function insertCart($finalproductarray)
	{

		$this->db->insert_batch('cart', $finalproductarray);


		if(($this->db->affected_rows() >= 1))
		{
		 return true;
		}
		else
		{
		return false;
		} 


	}
	
	public function FetchIndivisualOrder(){

		$userId = $_POST['userId'];
		$limit=10;
		$offset=$_POST['limitNumber'];
		$this->db->order_by('orderId','desc');
		   $query = $this->db->get_where('orderproduct',array(
		   	'userId' => $userId),$limit,$offset);
		   return $query->result_array();

	}//FetchIndivisualOrder
	
	public function FetchDetailedOrder(){

			     $orderId = $_POST['orderId'];
		  $this->db->select('c.*,p.productName');
$this->db->from('cart as c');
$this->db->join('product as p','p.productId = c.productId');
$this->db->where('orderId',$orderId);
$query = $this->db->get();
		   return $query->result_array();

	}//FetchDetailedOrder
	
	public function FetchUser($userId)
                {        
                $query=$this->db->get_where('userprofile',array('userId'=>$userId));
                
                return $query->result_array();
           	  }//FetchUser
                 


              public function UpdateUser()
                {        
                $userId = $_POST['userId'];	
                $userName = $_POST['userName'];
		        $userMobile = $_POST['userMobile'];
		  		$flatNumber = $_POST['flatNumber'];
				$address = $_POST['address'];
		       
							        		$data=array(
										    		'userName'=> $userName,
										    		'userMobile'=> $userMobile,
										    		'flatNumber'=> $flatNumber,
													'address'=> $address,
										    								    					
												);
				        			$this->db->where('userId', $userId);
									$this->db->update('userprofile', $data);
								    return ($this->db->affected_rows() != 1) ? false : true;

       		
			      
				
				}//UpdateUser
				
				public function getAdminToken(){
					$query=$this->db->get_where('userprofile',array('isAdmin'=>'1'));
					return $query->result_array();
				}//getAdminToken
				
				
		public function DeleteOrder(){
					$orderId=$_POST['orderId'];
					$data=array('isDelete'=>'1');
					$this->db->where('orderId',$orderId);
					$this->db->update('orderproduct',$data);
					return ($this->db->affected_rows() != 1) ? false : true;
				}//DeleteOrder
}


?>