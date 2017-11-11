<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
	
	        
			 	 public function UserRegistration()
                {        
                $userName = $_POST['userName'];
		        $userEmail = $_POST['userEmail'];
		        $userMobile = $_POST['userMobile'];
		        $password = $_POST['password'];
				$flatNumber = $_POST['flatNumber'];
				$address = $_POST['address'];
		        //$token = $_POST['token'];
				//$verification = $_POST['verification'];
				  $checkemail=$this->checkAlreadyEmail($userEmail);
				  if($checkemail==1){
			        		return 'emailPresent';
			        	}else{

			        		$data=array(
										    		'userName'=> $userName,
										    		'userEmail'=> $userEmail,
										    		'userMobile'=> $userMobile,
										    		'password'=> $password,
													'flatNumber'=> $flatNumber,
													'address'=> $address,
										    		//'token'=> $token
													//'verification'=> $verification
						    					
												);
				        			
								    $this->db->insert('userprofile', $data);
									 return ($this->db->affected_rows() != 1) ? false : true;
			        		
			        	}
				
				
				}//UserRegistration
				
				
				 public function check()
                {        
                $userEmail = $_POST['userEmail'];
		        $password = $_POST['password'];
				   $token = $_POST['token'];
				 $userType=$_POST['isAdmin'];
				
		        //$token=$_POST['token'];
		        if(!empty($userEmail) && !empty($password)){
					    $query = $this->db->get_where('userprofile', array('userEmail' => $userEmail, 
				        	                                           'password' => $password,'isAdmin'=>$userType));
				        $count = $query->num_rows() > 0;
						
				        if($count==1){
				        			$data=array(
										    		'token'=> $token
						    					);
				        			$this->db->where('userEmail',$userEmail);
								    $this->db->update('userprofile', $data);
				        	return $query;}
				        else{return false;}
				 }else{return false;}
             }//check

             public function getUserByMail($userEmail){
             		$this->db->where('userEmail',$userEmail);
				    $query = $this->db->get('userprofile');
				    return $query;
             	}//getUserByMail

             	public function checkAlreadyEmail($email){
             		$this->db->where('userEmail',$email);
				    $query = $this->db->get('userprofile');
				    if ($query->num_rows() > 0){
				        return true;
				    }
				    else{
				        return false;
				    }
             	}//checkAlreadyEmail


             	public function DisplayProduct()
                {        
                 $query = $this->db->get('product');
         return $query->result_array();
        
             }//DisplayProduct

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
				
				
				public function GetPassword(){

                $userEmailNumber=$_POST['userEmail'];
            	$query = $this->db->get_where('userprofile',array('userEmail'=>$userEmailNumber));
				  return $query->result();
             	}//ForgotPassword
             	
			
}
?>