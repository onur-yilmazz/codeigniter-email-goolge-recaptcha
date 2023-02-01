<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $config = array(
            "protocol" => "smtp",
            "smtp_host" => "mail.xxxxxx.com",
            "smtp_port" => "587",
            "smtp_user" => "noreply@xxxxxxxxx.com",
            "smtp_pass" => "xxxxxxxx",
            "charset" => "utf-8",
            "mailtype" => "html",
            "wordwrap" => true,
            "newline" => "\r\n",
        );
        $this->load->library("email",$config);
        $this->load->library("form_validation");
    }
    
    //mail-form.php View Code
    public function contact()
    {   
        $this->load->view("mail-form");
    }


    public function send_mail()
    {   
        if($this->input->post()){
            $this->form_validation->set_rules('name', 'name', 'required|trim');
            $this->form_validation->set_rules('email', 'email', 'required|trim');
            $this->form_validation->set_rules('phone', 'phone', 'required|trim');
            $this->form_validation->set_message(
                array("required" => "{field} required")
            );
            if ($this->form_validation->run() == FALSE){
                $viewData = new stdClass();
                $viewData->form_error = true;
                $this->load->view("mail-form",$viewData);
            }else{
              if(isset($_POST['g-recaptcha-response'])){
                $captcha=$_POST['g-recaptcha-response'];
              }
                if(!$captcha){
                    $google_error = array(
                        "result" => "Are you robot",
                        "type"  => "error"
                    );
                    $this->session->set_flashdata("google_error", $google_error); 
                    redirect(base_url("mail-form"));
                }else{
                    $captcha=$_POST['g-recaptcha-response'];
                    $secret = "!!!!!!recaptcha_secret_key!!!!!";
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$ip);
                    $result = json_decode($request,TRUE);
                      if($result['success']){
                        $name = $this->input->post("name");
                        $email = $this->input->post("email");
                        $phone = $this->input->post("phone");
                        $message = $this->input->post("message");
                        }else{
                            $email_message = "<h3>{$name} - ".$_SERVER['SERVER_NAME']."</h3><br>";
                            $email_message .= " <strong> Name : </strong> {$name}  <br>";
                            $email_message .= " <strong> Email : </strong> {$email}  <br>";
                            $email_message .= " <strong> Phone : </strong> {$phone}  <br>";
                            $email_message .= " <strong> Message : </strong> {$message}";
                            $this->email->from("xxxxxxxx","xxxxxxxxx");
                            $this->email->to("xxxxxxxx","xxxxxxxx");
                            $this->email->subject($name." E-Mail Title");
                            $this->email->message($email_message);
                            $send =$this->email->send();
                            if($send){
                                $alert = array(
                                    "title" => "Email has been sent.",
                                    "text" =>  "Success Text",
                                    "type"  => "success"
                                );
                                 $this->session->set_flashdata("alert", $alert); 
                                 redirect(base_url("mail-form"));
                            }else{
                                $alert = array(
                                    "title" => "Error Title",
                                    "text" =>  "Error Text",
                                    "type"  => "error"
                                );
                                print_r("Error");
                                $this->session->set_flashdata("alert", $alert); 
                                redirect(base_url("mail-form"));
                            }
                        }
                    }
                }
            }
        }
    }
}