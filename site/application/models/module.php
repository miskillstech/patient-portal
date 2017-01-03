<?php
//echo "Prak"; exit;
class Module extends CI_Model 
{
    function __construct()
    {
		$this->load->database();
        parent::__construct();
		
		$this->load->library('session');
		$session_id = $this->session->userdata('session_id');
		//session_start();
    }
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_patients(){
		$this->db->select('*');
		$this->db->from('psp_patients');
		$query = $this->db->get();
		return $query->result_array(); 	
		}
	public function get_patients_by_id($id){

		$this->db->select('*');
		$this->db->where("id",$id);
		$this->db->from('psp_patients');
		$query = $this->db->get();
		return $query->result_array();

		}

public function delete_patients($id){

		$this->db->where('id ', $id);
		$this->db->delete('psp_patients'); 

		}
public function update_patients($id){

		$this->db->where('id', $id);
		$this->db->update('psp_patients', $data);
		return true;

		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		function get_setting_values()
    {
		$this->db->select('setting_value');
		$this->db->from('psp_setting');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_setting_values_by_id($setting_id)
    {
		$this->db->select('setting_value');
		$this->db->where("setting_id",$setting_id);
		$this->db->from('psp_setting');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_admin_email()
    {
		$this->db->select('setting_value');
		$this->db->where("setting_key","admin_email");
		$this->db->from('psp_setting');
		$query = $this->db->get();
		$admin_email=$query->row()->setting_value;
		return $admin_email;
	}
	
	
	function get_temp_order_count($session_id)
    {
		//$session_id='9b176a9a5945e8f32d13ece725fe9fea';
		
		$this->db->select('tmp_order_id');
		$this->db->where('tmp_session_id', $session_id);
		$this->db->from('psp_order_details_tmp');
		$query = $this->db->get();
		
		//$count= $this->db->count_all('psp_order_details_tmp');
		$count=$query->num_rows();
		
		$this->db->select('tmp_order_id');
		$this->db->select('sum(tmp_total_cost) as total_price');
		$this->db->where('tmp_session_id', $session_id);
		$this->db->from('psp_order_details_tmp');
		$query2 = $this->db->get();
		
		$total_price=$query2->row()->total_price;
		$string=$count."$$$".$total_price;
		//return $this->db->count_all_results();
		//$this->db->count_all('psp_order_details_tmp');
		return $string;
		
    }
	
	function get_sliders()
    {
		$this->db->select('*');
		$this->db->where('slider_status', 'Active');
		$this->db->from('psp_slider');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_testimonials()
    {
		$this->db->select('*');
		$this->db->where('testimonial_status', 'Active');
		$this->db->from('psp_testimonial');
		$this->db->order_by('testimonial_date', 'DESC');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_partners()
    {
		$this->db->select('*');
		$this->db->where('partner_status', 'Active');
		$this->db->where('partner_image !=', '');
		$this->db->order_by('partner_name', 'ASC');
		$this->db->from('psp_partner');
		
		$this->db->order_by('partner_id', 'RANDOM');
    	$this->db->limit(20);
		
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	
	//----------------------------prak--------------------------------
	function get_all_events()
    {
		$this->db->select('*');
		$this->db->where('event_status', 'Active');
		$this->db->from('psp_event');
		$this->db->order_by('event_date_time', 'DESC');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_event_details($event_id)
    {
		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->from('psp_event');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	function get_brands()
    {
		$this->db->select('*');
		$this->db->where('brand_status', 'Active');
		$this->db->where('brand_image !=', '');
		$this->db->where('brand_link !=', '');
		$this->db->order_by('brand_name', 'ASC');
		$this->db->from('psp_brand');
		
		$this->db->order_by('brand_id', 'RANDOM');
    	$this->db->limit(20);
		
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_all_brands()
    {
		$this->db->select('*');
		$this->db->where('brand_status', 'Active');
		$this->db->order_by('brand_name', 'ASC');
		$this->db->from('psp_brand');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_random_video()
    {
		$this->db->select('*');
		$this->db->where('video_status', 'Active');
		$this->db->from('psp_video');
		$this->db->order_by('video_id', 'RANDOM');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_random_video_details($video_id)
    {
		$this->db->select('psp_video.video_url');
		$this->db->where('video_id', $video_id);
		$this->db->from('psp_video');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function check_subscription($subscription_email){
		
		$this->db->select('subscription_id');
		$this->db->where('subscription_email', $subscription_email);
		$this->db->from('psp_subscription');
		$query = $this->db->get();
		return $query->num_rows();

	}
	
	function store_subscription($data,$subscription_email)
    {
		$this->load->library('email');
		$to=$subscription_email;
		$admin_email = $this->module->get_admin_email();
		
		
		
		$message='<html><body><table width="80%" border="0">
			<tr>
			<td colspan="2">
			<a href="'.site_base_url().'" target="_blank"><img src="'.base_url().'images/logo.png" border="0"></a>
			</td>
			</tr>
			<tr>
			<td colspan="2" style="height:10px;"></td>
			</tr>
			<tr>
			<td width="429" colspan="2">
			<table width="97%" border="0" style="margin:15px;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#4a4a4a;font-weight:normal;margin-bottom:2px;">
			<tr>
			<td colspan="2">Dear Customer,</td>
			</tr>
			<tr>
			<td colspan="2" height="10px;"></td>
			</tr>
			<tr>
			<td colspan="2" height="10px;">Your NewsLetter Subcription is Completed on :</strong> '.date("F j, Y").'</td>
			</tr>
			<tr>
			<td colspan="2" height="10px;">We hope you enjoy receiving our daily newsletter from our Site.</td>
			</tr>
			<tr>
			<td colspan="2" height="10px;"></td>
			</tr>
			
			<tr>

			<td colspan="2" height="10px;"><p>Thanks,</p>
			  <p>Pasupati</p></td>
			</tr>
</table>';
			
			
			//echo $message;die;
				
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				
				$this->email->initialize($config);
				//$this->email->from($admin_email);
				$this->email->from($admin_email, 'Pasupati');
				$this->email->to($to);
				//$this->email->cc('prakash@webhawkstechnology.com');
				$this->email->subject('Pasupati::NewsLetter Subcription');
				$this->email->message($message);
				$this->email->send();
		
		$insert = $this->db->insert('psp_subscription', $data);
	    return $insert;
	}
	
	public function get_all_gallery_images($product_id)
    {
		$this->db->select('gallery_image');
		$this->db->where('product_id', $product_id);
		$this->db->where('gallery_image_status', 'Active');
		$this->db->from('psp_product_gallery');
		
		$query = $this->db->get();
		return $query->result_array();  
    }
	
	function get_country()
    {
		$this->db->select('*');
		$this->db->where('country_status', 'Active');
		$this->db->from('psp_country');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_state()
    {
		$this->db->select('*');
		//$this->db->where('country_status', 'Active');
		$this->db->from('psp_states');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function check_vendor($vendor_email)
	{
		$this->db->select('vendor_id');
		$this->db->where('vendor_email',$vendor_email);
		$this->db->from('psp_vendors');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function check_vendor_email($vendor_email,$id)
	{
		//echo $id;
		//echo $vendor_email;die;
		$this->db->select('*');
		$this->db->where('vendor_email',$vendor_email);
		$this->db->where('vendor_id !=', $id);
		$this->db->from('psp_vendors');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	
	
	function user_registration($data)
	{
		$insert = $this->db->insert('psp_vendors', $data);
		return $insert;
	}
    function company_info($data)
	{
		$insert = $this->db->insert('psp_company', $data);
		return $insert;
	}
	function user_login_profile1()
	{
		$this->load->helper('cookie');
		
		$customer_email = $this->input->post('email');
		$password = $this->input->post('password');
		$customer_password = md5($this->input->post('password'));
		
		if ($this->input->post('remember_me')=='1') {
			
			$this->input->set_cookie("username", $username,time()+60*60*60*7);
            $this->input->set_cookie("password", $password,time()+60*60*60*7);
			
		}
		else
		{
			$this->input->set_cookie("username", '',0);
            $this->input->set_cookie("password", '',0);
		}
		
		$this->db->select('customer_id,customer_name');
		$this->db->where('customer_email', $customer_email);
		$this->db->where('customer_password', $customer_password);
		$this->db->from('psp_customers');
		$query = $this->db->get();
		
		$result = $query->num_rows();
		if($result==0)
		{
			return false;
		}
		else
		{
			$data = $query->result_array();
		    $customer_name=$data[0]['customer_name'];
			$user_id=$data[0]['customer_id'];
		
			$this->session->set_userdata('user_name', $customer_name);
			$this->session->set_userdata('user_id', $user_id);
			$this->session->set_userdata('is_logged_in', TRUE);
			return true;
		}
		
	}
	

function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@04f7c318ad0360bd7b04c980f950833f11c0b1d1quot;#$%&[]{}?|";
        }
                                
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                
        
        return $password;
    }
	
	function set_capcha_session($word)
	{
		$this->session->set_userdata('captchaWord', $word);	
	}
	
	function vendor_forget_password($vendor_email)
	{
		$this->load->library('email');
	    $vendor_email= $vendor_email;//die;
		
		$this->db->select('*');
		$this->db->from('psp_vendors');
		$this->db->where("vendor_email",$vendor_email);
		$k=$this->db->get();
		$result = $k->num_rows();
		if($result==0)
		{
			return false;
		}
		else
		{
			$data = $k->result_array();
			$vendor_name=stripslashes($data[0]['vendor_fname']);
			$user_id=stripslashes($data[0]['vendor_id']);
			$vendor_email=stripslashes($data[0]['vendor_email']);
			
			$new_password=$this->module->get_random_password(6, 8, true, true, false);
			$this->module->update_user_password($user_id,$new_password);
			
			
			$this->db->select('setting_value');
			$this->db->where("setting_key","admin_email");
			$this->db->from('psp_setting');
			$query = $this->db->get();
		    $admin_email=$query->row()->setting_value;//die;
			  
		   
				
			$message='<html><body><table width="80%" border="0">
			<tr>
			<td colspan="2">
			<a href="'.site_base_url().'" target="_blank"><img src="'.base_url().'images/logo.png" border="0"></a>
			</td>
			</tr>
			<tr>
			<td colspan="2" style="height:10px;"></td>
			</tr>
			<tr>
			<td width="429" colspan="2">
			<table width="97%" border="0" style="margin:15px;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#4a4a4a;font-weight:normal;margin-bottom:2px;">
			<tr>
			<td colspan="2">Dear '.$vendor_name.',</td>
			</tr>
			<tr>
			<td colspan="2" height="10px;"></td>
			</tr>
			<tr>
			<td colspan="2" height="10px;">Your Password has been changed suceessfuly.</br>Your Email Address and New Password are given below..</td>
			</tr>
			<tr>
			<td colspan="2" height="10px;"></td>
			</tr>
			<tr>
				<td width="20%">Email Address: </td>
				<td >'.$vendor_email.'</td>
			</tr>
			<tr>
				<td width="20%">Password: </td>
				<td >'.$new_password.'</td>
			</tr>
			
			<tr>
			<td colspan="2" height="10px;"></td>
			</tr>
			
			<tr>

			<td colspan="2" height="10px;"><p>Thanks,</p>
			  <p>Pasupati.</p></td>
			</tr>
</table>';
			
			
			//echo $message;die;
				
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				
				$this->email->initialize($config);
				//$this->email->from($admin_email);
				$this->email->from($admin_email, 'Pasupati');
				$this->email->to($vendor_email);
				$this->email->subject('Confirmation Mail for Forget Password');
				$this->email->message($message);
				$this->email->send();
				//echo $this->email->print_debugger();
			
			   return true;	
		}
        
	}

	
    function get_customer_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('psp_customers');
		$this->db->where('customer_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	 function get_vendor_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('psp_vendors');
		$this->db->where('vendor_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	
	function update_detail_user($vendor_id,$data)
	{
		$this->db->where('vendor_id', $vendor_id);
		$this->db->update('psp_vendors', $data);
		return true;
	}
	
	function check_old_password($vendor_id,$old_password){
		$this->db->select('vendor_password');
		$this->db->where('vendor_password', $old_password);
		$this->db->where('vendor_id', $vendor_id);
		$this->db->from('psp_vendors');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function update_user_password($vendor_id,$new_password)
	{
		$data = array(
				'vendor_password'=>md5($new_password)
				);
		$this->db->where('vendor_id', $vendor_id);
		$this->db->update('psp_vendors', $data);
		return true;
	}
	
	function get_page_content_by_id($page_id)
	{
		$this->db->select('*');
		$this->db->from('psp_page');
		$this->db->where('page_id', $page_id);
		$this->db->where('page_status','Active');
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_group_company_info()
	{
		$this->db->select('*');
		$this->db->from('psp_associate_companies');
		$this->db->where('type','Group of copanies');
		$this->db->where('status','Active');
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_associate_companies()
	{
		//echo "ppp";die;
		$this->db->select('*');
		$this->db->from('psp_associate_companies');
		$this->db->where('type','Associats');
		$this->db->where('status','Active');
		//$this->db->limit(12);
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_job_by_id()
	{
		$this->db->select('*');
		$this->db->from('psp_job');
		$this->db->where('job_status','Active');
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_job($job_id)
	{
		$this->db->select('*');
		$this->db->from('psp_job');
		$this->db->where('job_status','Active');
		$this->db->where('job_id',$job_id);
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_news_content_by_id()
	{
		$this->db->select('*');
		$this->db->from('psp_news');
		//$this->db->where('page_id', $page_id);
		$this->db->where('news_status','Active');
		$this->db->order_by('news_id', 'RANDOM');
		$this->db->limit(2);
		$query = $this->db->get();
		return $query->result_array(); 
	}
	function get_management_team_content_by_id()
	{
		$this->db->select('*');
		$this->db->from('psp_manageteam');
		$this->db->where('status','Active');
		//$this->db->where('page_id', $page_id);
		$query = $this->db->get();
		return $query->result_array(); 
	}
	function get_setting_page_content($id)
	{
		//echo $id1;die;
		$this->db->select('*');
		$this->db->from('psp_setting');
		$this->db->where_in('setting_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
	}
	function get_product_by_id($product_id)
    {
		$this->db->select('*');
		$this->db->from('psp_product');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function check_recently_viewed_product($product_id,$ip_address)
    {
		$this->db->select('view_id');
		$this->db->where('product_id', $product_id);
		$this->db->where('ip_address', $ip_address);
		$this->db->from('psp_recently_viewed_product');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function store_recently_viewed_product($data)
	{
	$insert = $this->db->insert('psp_recently_viewed_product', $data);
	return $insert;
	}
	
	function check_temp_cart($product_id,$session_id)
	{
		$this->db->select('*');
		$this->db->where('tmp_item_id', $product_id);
		$this->db->where('tmp_session_id', $session_id);
		$this->db->from('psp_order_details_tmp');
		$query = $this->db->get();
		return $query->num_rows();

	}
	
	function add_to_tempcart($product_id,$price)
	{
	$session_id = $this->session->userdata('session_id');
	if($this->module->check_temp_cart($product_id,$session_id))
		{
			//echo "exist"; //die;
			$data['exist_message'] = TRUE; 
		}
		else
		{ 
			//echo "new"; //die;
			$session_user_id =$this->session->userdata('user_id');
	
			$data_temp = array(
							'tmp_usr_id' => $session_user_id,
							'tmp_session_id' => $session_id,
							'tmp_item_id' => $product_id,
							'tmp_unit_cost' => $price,
							'tmp_product_quantity' => 1,
							'tmp_total_cost' => $price
							);		
			//echo "<pre>"; print_r($data_temp); die;				
			$insert = $this->db->insert('psp_order_details_tmp', $data_temp);
			return $insert;
		
		}
	
	}
	
	function get_temp_shoppingcart($tmp_session_id)
    {
		$this->db->select('psp_order_details_tmp.*');
		$this->db->select('psp_product.product_name,ste_product.product_image,ste_product.product_overview');
		$this->db->where('tmp_session_id', $tmp_session_id);
		$this->db->order_by('tmp_order_id', 'Desc');
		$this->db->from('psp_order_details_tmp');
		
		$this->db->join('psp_product', 'ste_product.product_id = ste_order_details_tmp.tmp_item_id');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_temp_shipping($tmp_session_id)
    {
		$shipping=0;
		$this->db->select('psp_order_details_tmp.tmp_item_id');
		$this->db->select('psp_product.free_shipping');
		$this->db->where('psp_order_details_tmp.tmp_session_id', $tmp_session_id);
		$this->db->where('psp_product.free_shipping',$shipping);
		$this->db->from('psp_order_details_tmp');
		
		$this->db->join('psp_product', 'ste_product.product_id = ste_order_details_tmp.tmp_item_id');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_valid_deals($today,$total_cost,$coupon_code)
    {
		$this->db->select('*');
		$this->db->where('min_bill_amount <=', $total_cost);
		$this->db->where('valid_to >=', $today);
		$this->db->where('valid_from <=', $today);
		$this->db->where('coupon_code', $coupon_code);
		$this->db->order_by('min_bill_amount', 'Desc');
		$this->db->limit(1);
		$this->db->from('psp_deal');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function update_tempcart($tmp_order_id,$quantity,$tmp_total_cost)
	{
		//echo $tmp_order_id; die;
		$data = array(
				'tmp_product_quantity' => $quantity,
				'tmp_total_cost' => $tmp_total_cost
				);
		//echo "<pre>"; print_r($data); die;
		$this->db->where('tmp_order_id ', $tmp_order_id);
		$this->db->update('psp_order_details_tmp', $data);
		return true;
	}	
	function delete_cart($tmp_order_id)
	{
		$this->db->where('tmp_order_id ', $tmp_order_id);
		$this->db->delete('psp_order_details_tmp'); 
	}
	
	function total_price_of_cart()
	{
		$session_id = $this->session->userdata('session_id');
		$this->db->select_sum('tmp_total_cost','tmp_total_cost');
		$this->db->where('tmp_session_id', $session_id);
		$this->db->from('psp_order_details_tmp');
		$query = $this->db->get();
		$total=$query->row()->tmp_total_cost;
		return $total;

	}

	function store_temp_order_shoppingcart($data)
	{
	$insert = $this->db->insert('psp_order_tmp', $data);
	return $insert;
	}
	
	public function get_all_carmakes()
    {
		$this->db->select('*');
		$this->db->from('psp_carmake');
		$this->db->where('carmake_status', 'Active');
		$query = $this->db->get();
		return $query->result_array();  
    }
	
	public function get_all_carmodels_carmake_id($carmake_id)
    {
		$this->db->select('*');
		$this->db->from('psp_carmodel');
		$this->db->where('carmodel_make_id', $carmake_id);
		$this->db->where('carmodel_status', 'Active');
		$query = $this->db->get();
		return $query->result_array();  
    }
	
	public function get_all_carbodies_carmake_id_and_carmodel_id($carmake_id,$carmodel_id)
    {
		$this->db->select('carmodel_body_ids');
		$this->db->from('psp_product');
		$this->db->where('carmodel_body_ids !=', '');
		$select_carmake_id_string=",".$carmake_id.",";
		if($select_carmake_id_string){
								 $this->db->like('carmake_ids', $select_carmake_id_string);
								 }
		$select_carmodel_id_string=",".$carmodel_id.",";
		if($select_carmodel_id_string){
								 $this->db->like('carmodel_ids', $select_carmodel_id_string);
								 }
								 
		$query = $this->db->get();
		$count_number=$query->num_rows();
		
		return $count_number; 
    }
	
	public function get_all_carbodies()
    {
		$this->db->select('*');
		$this->db->from('psp_carmodel_body');
		$this->db->where('carmodel_body_status', 'Active');
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	function store_session_vehicle($data)
	{
	$insert = $this->db->insert('psp_session_vehicle', $data);
	return $insert;
	}
	
	public function get_session_vehicle()
    {
		$session_id = $this->session->userdata('session_id');
		$this->db->select('*');
		$this->db->from('psp_session_vehicle');
		$this->db->where('session_id', $session_id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	public function get_search_results($year,$carmake_id,$carmodel_id,$carbody_id)
    {
		$this->db->select('psp_product.product_id,ste_product.category_id,ste_product.sub_category_id');
		$this->db->select('psp_category.category_id,ste_category.category_name,ste_category.category_image');
		$this->db->from('psp_product');
		$label=0;
		$this->db->where('psp_product.product_launching_year', $year);
		$this->db->where('psp_category.label', $label);
		$select_carmake_id_string=",".$carmake_id.",";
		if($select_carmake_id_string){
								 $this->db->like('psp_product.carmake_ids', $select_carmake_id_string);
								 }
		$select_carmodel_id_string=",".$carmodel_id.",";
		if($select_carmodel_id_string){
								 $this->db->like('psp_product.carmodel_ids', $select_carmodel_id_string);
								 }
		$select_carbody_id_string=",".$carbody_id.",";
		if($select_carbody_id_string){
								 $this->db->like('psp_product.carmodel_body_ids', $select_carbody_id_string);
								 }						 
		
		
		$this->db->join('psp_category', 'ste_product.category_id = ste_category.category_id', 'inner');
		$this->db->group_by('psp_product.category_id');
		
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	public function get_brand_search_results($brand_id)
    {
		$this->db->select('psp_product.product_id,ste_product.category_id,ste_product.sub_category_id');
		$this->db->select('psp_category.category_id,ste_category.category_name,ste_category.category_image');
		$this->db->from('psp_product');
		$label=0;
		$this->db->where('psp_product.brand_id', $brand_id);
		$this->db->where('psp_category.label', $label);
		
		$this->db->join('psp_category', 'ste_product.category_id = ste_category.category_id', 'inner');
		$this->db->group_by('psp_product.category_id');
		
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	public function get_brand_search_subcat_results($brand_id,$category_id)
    {
		$this->db->select('psp_product.product_id,ste_product.category_id,ste_product.sub_category_id,count(product_id) as count_no');
		$this->db->select('psp_category.category_id,ste_category.category_name');
		$this->db->from('psp_category');
		
		$label=1;
		$this->db->where('psp_product.category_id', $category_id);
		$this->db->where('psp_product.brand_id', $brand_id);
		$this->db->where('psp_category.label', $label);
							 
		$this->db->join('psp_product', 'ste_category.category_id = ste_product.sub_category_id', 'inner');
		$this->db->group_by('psp_product.sub_category_id');
		
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	public function get_category_search_results($category_id,$sarch_value)
    {
		//echo $category_id."==".$sarch_value; die;
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.category_id', $category_id);
		$this->db->like('psp_product.product_name', $sarch_value);
		$query = $this->db->get();
		return $query->result_array();
    }
	
	public function get_search_subcat_results($year,$carmake_id,$carmodel_id,$carbody_id,$category_id)
    {
		$this->db->select('psp_product.product_id,ste_product.category_id,ste_product.sub_category_id,count(product_id) as count_no');
		$this->db->select('psp_category.category_id,ste_category.category_name');
		$this->db->from('psp_category');
		
		$label=1;
		$this->db->where('psp_product.product_launching_year', $year);
		$this->db->where('psp_product.category_id', $category_id);
		
		$this->db->where('psp_category.label', $label);
		$select_carmake_id_string=",".$carmake_id.",";
		if($select_carmake_id_string){
								 $this->db->like('psp_product.carmake_ids', $select_carmake_id_string);
								 }
		$select_carmodel_id_string=",".$carmodel_id.",";
		if($select_carmodel_id_string){
								 $this->db->like('psp_product.carmodel_ids', $select_carmodel_id_string);
								 }
		$select_carbody_id_string=",".$carbody_id.",";
		if($select_carbody_id_string){
								 $this->db->like('psp_product.carmodel_body_ids', $select_carbody_id_string);
								 }						 
		$this->db->join('psp_product', 'ste_category.category_id = ste_product.sub_category_id', 'inner');
		
		$this->db->group_by('psp_product.sub_category_id');
		
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	public function get_subcategory_name($sub_category_id)
    {
		$this->db->select('category_name');
		$this->db->where('category_id', $sub_category_id);
		$this->db->from('psp_category');
		$query = $this->db->get();

		$category_name=$query->row()->category_name;
		return $category_name;
    }
	
	public function get_last_sarching_key()
    {
		$session_id = $this->session->userdata('session_id');
		$this->db->select('sarching_key');
		$this->db->from('psp_session_vehicle');
		$this->db->where('session_id', $session_id);
		$this->db->order_by('session_vehicle_id', 'DESC');
    	$this->db->limit(1);
		$query = $this->db->get();

		$sarching_key=$query->row()->sarching_key;
		return $sarching_key;
    }
	
	public function get_category_product_list($category_id, $limit_start=null, $limit_end=null)
    {
		$sarching_key=$this->module->get_last_sarching_key();
		$explode=explode("|",$sarching_key);
			$count = count($explode);
			$year=end($explode);
			$carmake_id=$explode[$count-2];
			if($count>3)
			$carmodel_id=$explode[$count-3];
			else
			$carmodel_id=0;
			if($count>4)
			$carbody_id=$explode[$count-4];
			else
			$carbody_id=0;
			
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.product_launching_year', $year);
		$this->db->where('psp_product.category_id', $category_id);
		$select_carmake_id_string=",".$carmake_id.",";
		if($select_carmake_id_string){
								 $this->db->like('psp_product.carmake_ids', $select_carmake_id_string);
								 }
		$select_carmodel_id_string=",".$carmodel_id.",";
		if($select_carmodel_id_string){
								 $this->db->like('psp_product.carmodel_ids', $select_carmodel_id_string);
								 }
		$select_carbody_id_string=",".$carbody_id.",";
		if($select_carbody_id_string){
								 $this->db->like('psp_product.carmodel_body_ids', $select_carbody_id_string);
								 }
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		return $query->result_array();

    }
	
	public function get_subcategory_product_list($sub_category_id, $limit_start=null, $limit_end=null)
    {
		$sarching_key=$this->module->get_last_sarching_key();
		$explode=explode("|",$sarching_key);
			$count = count($explode);
			$year=end($explode);
			$carmake_id=$explode[$count-2];
			if($count>3)
			$carmodel_id=$explode[$count-3];
			else
			$carmodel_id=0;
			if($count>4)
			$carbody_id=$explode[$count-4];
			else
			$carbody_id=0;
			
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.product_launching_year', $year);
		$this->db->where('psp_product.sub_category_id', $sub_category_id);
		$select_carmake_id_string=",".$carmake_id.",";
		if($select_carmake_id_string){
								 $this->db->like('psp_product.carmake_ids', $select_carmake_id_string);
								 }
		$select_carmodel_id_string=",".$carmodel_id.",";
		if($select_carmodel_id_string){
								 $this->db->like('psp_product.carmodel_ids', $select_carmodel_id_string);
								 }
		$select_carbody_id_string=",".$carbody_id.",";
		if($select_carbody_id_string){
								 $this->db->like('psp_product.carmodel_body_ids', $select_carbody_id_string);
								 }
		
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		return $query->result_array();

    }
	
	public function get_category_allproduct_list($category_id, $limit_start=null, $limit_end=null)
    {
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.product_status', 'Active');
		$this->db->where('psp_product.category_id', $category_id);
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		return $query->result_array();
    }
	
	public function get_subcategory_allproduct_list($category_id, $limit_start=null, $limit_end=null)
    {
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.product_status', 'Active');
		$this->db->where('psp_product.sub_category_id', $category_id);
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		return $query->result_array();
    }
	
	public function get_product_list_by_brand($brand_id, $limit_start=null, $limit_end=null)
    {
		$this->db->select('psp_product.product_id,ste_product.product_name,ste_product.product_image,ste_product.product_price,ste_product.product_discounted_price,ste_product.product_overview');
		$this->db->from('psp_product');
		$this->db->where('psp_product.product_status', 'Active');
		$this->db->where('psp_product.brand_id', $brand_id);
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		return $query->result_array();
    }
	
	function get_orders_by_vendor($vendor_id)
	{
		//echo $vendor_id;die;
		$order_status='Active';
		$this->db->select('order_id,order_gen_id,order_date,order_amount');
		$this->db->where('vendor_id', $vendor_id);
		$this->db->where('order_status', $order_status);
		//$this->db->order_by('order_id', 'Desc');
		$this->db->from('psp_order');
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function get_order_details($order_id)
	{
		$this->db->select('psp_order_details.*');
		//$this->db->select('psp_product.product_name,psp_product.product_image');
		$this->db->where('psp_order_details.order_id', $order_id);
		//$this->db->order_by('psp_order_details.ordr_dtl_id', 'Desc');
		$this->db->from('psp_order_details');
		//$this->db->join('psp_product', 'psp_order_details.order_id = psp_product.product_id', 'inner');
	
		$query = $this->db->get();
		return $query->result_array(); 
	}
	function get_order_history($order_id)
	{
		$order_history_status='Active';
		$this->db->select('psp_order_history.*');
		//$this->db->select('psp_product.product_name,psp_product.product_image');
		$this->db->where('psp_order_history.order_id', $order_id);
		//$this->db->order_by('psp_order_details.ordr_dtl_id', 'Desc');
		$this->db->where('order_history_status', $order_history_status);
		$this->db->from('psp_order_history');
		//$this->db->join('psp_product', 'psp_order_details.order_id = psp_product.product_id', 'inner');
	
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	
	function get_order_info_by_order_id($order_id)
	{
		$this->db->select('*');
		$this->db->where('order_gen_id', $order_id);
		$this->db->from('psp_order');
		
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	function update_temp_order($customer_id,$session_id, $data)
    {
		$this->db->where('tmp_usr_id', $customer_id);
		$this->db->where('tmp_session_id', $session_id);
		$this->db->update('psp_order_tmp', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	function get_temp_order_details($tmp_session_id)
    {
		$this->db->select('psp_order_details_tmp.*');
		$this->db->select('psp_product.product_name');
		$this->db->where('psp_order_details_tmp.tmp_session_id', $tmp_session_id);
		$this->db->from('psp_order_details_tmp');
		$this->db->join('psp_product', 'ste_product.product_id = ste_order_details_tmp.tmp_item_id');
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_temp_orders($tmp_session_id)
    {
		$this->db->select('*');
		$this->db->where('tmp_session_id', $tmp_session_id);
		$this->db->from('psp_order_tmp');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function insert_order($data)
	{
		$insert = $this->db->insert('psp_order', $data);
		return $insert;
	}
	function insert_order_details($data)
	{
		$insert = $this->db->insert('psp_order_details', $data);
		return $insert;
	}
	
	function delete_all_temp_order_details($tmp_session_id)
	{
		$this->db->where('tmp_session_id ', $tmp_session_id);
		$this->db->delete('psp_order_details_tmp'); 
	}
	function delete_temp_order($tmp_session_id)
	{
		$this->db->where('tmp_session_id ', $tmp_session_id);
		$this->db->delete('psp_order_tmp'); 
	}
	
	function setting_value($setting_key)
    {
		$this->db->select('setting_value');
		$this->db->from('psp_setting');
		$this->db->where('setting_key', $setting_key);
		$query = $this->db->get();

		$setting_value=$query->row()->setting_value;
		return $setting_value;
    }
	
	function get_setting_value($setting_id)
    {
		$this->db->select('setting_value');
		$this->db->from('psp_setting');
		$this->db->where('setting_id', $setting_id);
		$query = $this->db->get();

		$setting_value=$query->row()->setting_value;
		return $setting_value;
    }
	
	function get_total_amount($order_gen_id)
    {
		$this->db->select('order_total_cost');
		$this->db->from('psp_order');
		$this->db->where('order_gen_id', $order_gen_id);
		$query = $this->db->get();

		$order_total_cost=$query->row()->order_total_cost;
		return $order_total_cost;
    }
	function update_payment_status($order_gen_id,$data)
	{
		$this->db->where('order_gen_id', $order_gen_id);
		$this->db->update('psp_order', $data); 
		return true;
	}
	
	function get_carmake_name_by_id($carmodel_make_id)
    {
		$this->db->select('carmake_name');
		$this->db->where('carmake_id', $carmodel_make_id);
		$this->db->from('psp_carmake');
		$query = $this->db->get();
		//return $this->db->get()->row()->name;
		$rowcount = $query->num_rows();
		
		if($rowcount > 0)
		{
			$carmake_name=$query->row()->carmake_name;
			return $carmake_name;
		}
		else{
			return "Not Available";
		}

    }
	

	function count_products($type, $category_id)
    {
		$this->db->select('product_id');
		$this->db->from('psp_product');
		$this->db->where('product_status', 'Active');
		if($type=='category' || $type=='allcategory')
		$this->db->where('psp_product.category_id', $category_id);
		else
		$this->db->where('psp_product.sub_category_id', $category_id);
		$this->db->order_by('product_id', 'Asc');
		$query = $this->db->get();
		return $query->num_rows();        
    }
	
	function count_products_by_brand($brand_id)
    {
		$this->db->select('product_id');
		$this->db->from('psp_product');
		$this->db->where('product_status', 'Active');
		$this->db->where('psp_product.brand_id', $brand_id);
		$this->db->order_by('product_id', 'Asc');
		$query = $this->db->get();
		return $query->num_rows();        
    }
	
	function get_brand_info_by_brand_id($brand_id)
    {
		$this->db->select('*');
		$this->db->where('brand_id', $brand_id);
		$this->db->from('psp_brand');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	function get_category_info_by_category_id($category_id)
    {
		$this->db->select('*');
		$this->db->where('category_id', $category_id);
		$this->db->from('psp_category');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
//================prak=============prakash=============prak===============================	
	 public function get_order_list($user_id,$limit_start, $limit_end)
    {
		$this->db->select('*');	
		$this->db->where('usr_id', $user_id);
		$this->db->where('order_status','Active');
		$this->db->order_by('order_id', 'Desc');
		$this->db->from('psp_order');
		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');
		$query = $this->db->get();
		return $query->result_array(); 	
    }

public function product_search()
       {
		  $zero=0;
		
		$this->db->select('product_name,product_id,product_small_image,product_overview');
		//$this->db->where('category_status', 'Active');
		$this->db->where('prent_id =', $zero);
		$this->db->order_by('product_id', 'Desc');
		$this->db->from('psp_product');
		
		$query = $this->db->get();
		return $query->result_array();  	
       }

	   
	    function  get_productpage($product_id)
	    {
			
		
		$this->db->select('*');
		$this->db->where('product_id',$product_id);
		$this->db->from('psp_product');
		
		$query = $this->db->get();
		return $query->result_array(); 	
       }
	   
	  
	   function   get_sub_productpage($product_id)
	    {
		//echo $product_id;die;	
		
		$this->db->select('*');
		$this->db->where('prent_id',$product_id);
		$this->db->from('psp_product');
		
		$query = $this->db->get();
		return $query->result_array(); 	
       }
	    function   get_sub_product($product_id)
	    {
		//echo $product_id;die;	
		
		$this->db->select('*');
		$this->db->where('product_id',$product_id);
		$this->db->from('psp_product');
	
		$query = $this->db->get();
		return $query->result_array(); 	
		
       }
	   
	   
function user_login_profile()
	{
		//setting cookie
	
		
	    $email = $this->input->post('email');//die;
		$password = $this->input->post('password');
		$user_password = md5($this->input->post('password'));
		
	
		//setting cookie
		
		$this->db->select('vendor_id,vendor_email');
		$this->db->where('vendor_email', $email);
		$this->db->where('vendor_password', $user_password);
		$this->db->where('vendor_status', "Active");
		$this->db->from('psp_vendors');
		$query = $this->db->get();
		$result = $query->num_rows();
		//print_r($result); die;
		if($result==0)
		{
			return false;
		}
		else
		{
			$data = $query->result_array();
		    $user_email=$data[0]['vendor_email'];
			$user_id=$data[0]['vendor_id'];
		
			$this->session->set_userdata('vendor_email', $user_email);
			$this->session->set_userdata('vendor_id', $user_id);
			$this->session->set_userdata('is_logged_in', TRUE);
			return true;
		}
		
	}	   
	   
 //Tanay=================================================
	function get_recent_products(){
		//echo $product_id;die;
		$zero=0;
		
		$this->db->select('product_name,product_id,product_small_image,product_overview');
		//$this->db->where('category_status', 'Active');
		$this->db->where('prent_id', $zero);
		$this->db->from('psp_product');
		$this->db->order_by('product_date','Asc');
		$this->db->limit(3);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_feture_products(){
		$product_feature=1;
		$this->db->select('*');
		//$this->db->where('category_status', 'Active');
		$this->db->where('product_feature', $product_feature);
		$this->db->from('psp_product');
		$this->db->limit(6);
		$query=$this->db->get();
		return $query->result_array();
	}
  //Tanay=================================================
   
function get_vision_img(){
		
		$this->db->select('*');
		$this->db->from('psp_vision_img');
		$this->db->where('img_status','Active');
		$this->db->order_by('img_id', 'RANDOM');
		$this->db->limit(4);
		$query=$this->db->get();
		return $query->result_array();
	}	
}
?>