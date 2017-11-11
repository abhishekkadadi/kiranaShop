<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function UserRegistration(){
       $userEmail = $_POST['userEmail'];
           
      $this->load->model('User_model');
          $data=$this->User_model->UserRegistration();

          if($data === 'emailPresent')
          {
             $userdata['status']=email_present();
             $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
               
          }
          else if($data){
               
              $data2=$this->User_model->getUserByMail($userEmail);
             foreach ($data2->result() as $key) {
                        $userId=$key->userId;
                        $userName=$key->userName;
             }
                $send_mail=$this->sendMail($userId,$userName,$userEmail); 
              $userdata['status']=success_insert();
     

                                  
                 
                 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
          }else{
               $final_data=array('status'=>'0','message'=>'Something went wrong');
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }
         }//SendNotification
		 
 public function LoginCheck(){
			$this->load->model('User_model');
          $data=$this->User_model->check();
		  
          if($data){
                  
                  foreach ($data->result() as $row) {
                      $userDetails=array(
                          'userId'=>$row->userId,
                                'userName'=>$row->userName,
                                  'userEmail'=>$row->userEmail,
                                    'userMobile'=>$row->userMobile,
                                  'flatNumber'=>$row->flatNumber,
                                    'address'=>$row->address
                               // 'password'=>$row->password
                               
                                );
                              
                 }//foreach

               
                 
				 $userdata['status']=array('status'=>'1','message'=>'Successfully logged in');
                 $userdata['userData']=$userDetails;
                 
                 
                 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
          }else{
               
                $final_data['status']=login_failed();
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }
         }
		 
		  public function sendMail($userId,$userName,$userEmail){
  ini_set('max_execution_time', 108000);
                $userId=urlencode(base64_encode($userId));
                $result['sitelink']= site_url("Verifymail/Verify/$userId");
              $result['email']=$userEmail;
              $result['name']=$userName;
                $html=$this->load->view('emailtemplate', $result, true);
                $this->load->library('email');
              /*  $this->email->initialize(array(
                                                 'protocol' => 'smtp',
                                                'smtp_host' => 'smtp.sendgrid.net',
                                                'smtp_user' => 'akadadi',
                                                  'smtp_pass' => 'danger44',
                                                'smtp_port' => 25,
                                                'crlf' => "\r\n",
                                                'newline' => "\r\n"
                                              ));*/
                  $this->email->set_mailtype("html");
              $this->email->from('info@kiranashop.in', 'TheKiaranaShop');
              $this->email->to($userEmail);
              $this->email->subject('The Kiarana Shop App Email Verification');
              $this->email->message($html);
              if($this->email->send()){
                return;
               //echo 'sent';
              }else{
                print_r($this->email->print_debugger(), true);
                //echo 'failed';
              // return;//mail sending failed please contact software providers
              }
    }//sendmail

public function DisplayProduct(){
      $this->load->model('User_model');
          $data=$this->User_model->DisplayProduct();
      $final_data=array();
          if($data){
                
                  
         /*foreach($data as $key)
         {
           $data1=array(
           
          $noticeId=$key->noticeId,
          $noticeTitle=$key->noticeTitle,
          $noticeContent=$key->noticeContent,
          $selectedClass=$key->selectedClass,
          $selectedYear=$key->selectedYear,          
          $timeStamp=$key->timeStamp,
           );
         }*/
                 //print_r($data1);
         $final_data['status']=array('status'=>'1','message'=>'Successfully Data fetch');
                 $final_data['data']=$data;                
                 
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else{
               //$final_data=array('status'=>'0','message'=>'Something went wrong');
              // $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }
         }//DisplayNotification  

         public function UpdateUser(){
           $this->load->model('User_model');
          $data=$this->User_model->UpdateUser();

     
          if($data)
          {
            $userId = $_POST['userId'];
            $data2=$this->User_model->FetchUser($userId);
                
           $final_data['status']=array('status'=>'1','message'=>'User profile update successsfully.');
            $final_data['data']=$data2;                        
                
           
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else
          {
             $final_data['status']=array('status'=>'0','message'=>'Something went wrong..'); 
             $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }
         }//UpdateUser

  public function ForgotPassword(){
    $this->load->model('User_model');
    $data=$this->User_model->GetPassword();
    if($data){
              foreach ($data as $key) {
                $userName=$key->userName;
                $userPassword=$key->password;
                $userEmail=$key->userEmail;
                $result['userPassword']=$userPassword;
                $result['name']=$userName;
              }
                $html=$this->load->view('forgotpassword', $result, true);

                $this->load->library('email');
               /* $this->email->initialize(array(
                                                 'protocol' => 'smtp',
                                                'smtp_host' => 'smtp.sendgrid.net',
                                                'smtp_user' => 'akadadi',
                                                  'smtp_pass' => 'danger44',
                                                'smtp_port' => 587,
                                                'crlf' => "\r\n",
                                                'newline' => "\r\n"
                                              ));*/
              $this->email->set_mailtype("html");
              $this->email->from('info@whitecode.co.in', 'kiranashop');
              $this->email->to($userEmail);
              $this->email->subject('kiranashop App password request');
              $this->email->message($html);
               if($this->email->send()){
                $final_data['status']=mail_sent();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }else{
                $final_data['status']=mail_failed();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }
              
    }else{
            $final_data['status']=nodata_fetch();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }

 }//ForgotPassword









}//User

?>