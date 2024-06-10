<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
        $this->load->driver('cache');
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->model('financemodel');
        $this->load->helper('menu');
        $this->load->helper('app_helper');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    }

    public function index() {
        $this->load->model('financemodel', "a");
        $this->load->view("view_details");
    }

    public function settings() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('credit' => $_POST['credit'],
                'debit' => $_POST['debit'],
//                'commision' => $_POST['commision'],
//                'loans' => $_POST['loans'],
//                'cash' => $_POST['cash'],
            );
            $this->financemodel->settings($data);
            $this->session->set_flashdata('success', 'Added successfully!');
        }
        $data['template'] = "admin/settings";
        $this->load->view('admin/template', $data);
    }

    public function login() {
        if (isset($_POST) && !empty($_POST)) {
            $check = $this->db->get_where('admin', array('user_name' => $_REQUEST['user_name'], 'password' => $_REQUEST['password']))->row();
            if (!empty($check)) {
                $this->session->set_userdata('admin_id', $check->admin_id);
                $this->session->set_userdata('admin', $check);

                $this->session->set_flashdata('success', 'Login successfully!');
                redirect('admin/loan_display', 'refresh');
                $this->load->dbutil();
                $db_format = array('format' => 'zip', 'filename' => 'rayaztec_finance_backup.sql');
                $backup = & $this->dbutil->backup($db_format);
                $dbname = 'backup-on-' . date('Y-m-d') . '.zip';
                $save = 'theme/db_backup/' . $dbname;
                write_file($save, $backup);
                force_download($dbname, $backup);
            } else {
                $this->session->set_flashdata('error', 'Email/Password mismatch!');
                redirect('admin/login', 'refresh');
            }
        }

        $data['template'] = "admin/login";
        $this->load->view('admin/adminlogintemplate', $data);
    }

   public function database_backup() {
        $this->load->dbutil();
        $db_format = array('format' => 'zip', 'filename' => 'rayaztec_finance.sql');
        $backup = & $this->dbutil->backup($db_format);
        $dbname = 'backup-on-' . date('Y-m-d') . '.zip';
        $save = 'db_backup/' . $dbname;
        write_file($save, $backup);
        force_download($dbname, $backup);
    }

    protected function str_rand($length = 8, $output = 'alphanum') {
        // Possible seeds
        $outputs['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
        $outputs['numeric'] = '0123456789';
        $outputs['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
        $outputs['hexadec'] = '0123456789abcdef';
        // Choose seed
        if (isset($outputs[$output])) {
            $output = $outputs[$output];
        }
        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        // Generate
        $str = '';
        $output_count = strlen($output);
        for ($i = 0; $length > $i; $i++) {
            $str .= $output{mt_rand(0, $output_count - 1)};
        }
        return $str;
    }

    function sendmail($from, $to, $subject, $message) {
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($from);
        $this->email->to($to);
        $this->email->cc('info@lobis.in');
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = 'mohana.rayaz@gmail.com';
        $config['smtp_pass'] = 'rayaz123!@#';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      
        $this->email->initialize($config);
        $this->email->from('mohana.rayaz@gmail.com');
        $this->email->to($this->input->post('email_id'));
        //$this->email->subject('Email Test');
        // $this->email->message('Testing the email class.');
        $this->email->send();
        //echo $this->email->print_debugger();
        // the message
        $msg = $message;
// use wordwrap() if lines are longer than 70 characters
        //  $msg = wordwrap($msg, 70);
// send email
        //  $success = mail("testuserlt1@gmail.com", "My subject", $msg);
        //  if (!$success) {
        //      $errorMessage = error_get_last()['message'];
        //  }
        //exit;
    }

    public function forgotpassword() {
        if (isset($_REQUEST) && !empty($_REQUEST)) {
            $check = $this->db->get_where('admin', array('email_id' => $_REQUEST['email_id']))->row();
            if (!empty($check)) {
                $emailcontent = $this->db->get_where('emailcontent', array('emailcontent_id' => '1'))->row();
                if (!empty($emailcontent)) {
                    $pass = $this->str_rand();
                    $password = $pass;
                    $this->db->where('admin_id', $check->admin_id);
                    $this->db->update('admin', array('password' => $password));
                    $str = array('{user_name}' => $check->user_name, '{email_id}' => $check->email_id, '{password}' => $pass, '{link}' => base_url('admin/login'));
                    $email_content = strtr($emailcontent->emailcontent, $str);
                    $this->sendmail($emailcontent->fromemail, $check->email_id, $emailcontent->subject, $email_content);
                    $this->session->set_flashdata('success', 'Email with temp password has been sent');
                    redirect('admin/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Email not exists!');
                redirect('admin/forgotpassword', 'refresh');
            }
        }
        $data['template'] = "admin/forgotpassword";
        $this->load->view('admin/adminlogintemplate', $data);
    }

    public function changepassword() {
        $this->checkadmin();
        if (isset($_REQUEST) && !empty($_REQUEST)) {
            $update = $this->input->post();
            $check = $this->db->get_where('admin', array('password' => ($update['oldpassword']), 'admin_id' => $this->session->userdata('admin_id')))->row();
            if (!empty($check)) {
                $password = ($update['password']);
                $this->db->where('admin_id', $check->admin_id);
                $this->db->update('admin', array('password' => $password));
                $this->session->set_flashdata('success', 'Password updated successfully!');
                redirect('admin/profile?tab=changepassword', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Password mismatch!');
                redirect('admin/profile?tab=changepassword', 'refresh');
            }
        }
    }

    public function profile() {
        if (isset($_POST) && !empty($_POST)) {
            $update = $this->input->post();
            $check = $this->db->get_where('admin', array('email_id' => $update['email_id'], 'admin_id !=' => $this->session->userdata('admin_id')))->row();
            if (empty($check)) {
                if (isset($_FILES['profile']['name']) && !empty($_FILES['profile']['name'])) {
                    $update['profile'] = rand(0, 9999) . $_FILES['profile']['name'];
                    move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $update['profile']);
                }
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', $update);
                $this->session->set_flashdata('success', 'Profile updated successfully!');
                redirect('admin/profile', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Email already exists!');
                redirect('admin/profile', 'refresh');
            }
        }
        $data['result'] = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row();
        $data['template'] = "admin/profile";
        $this->load->view('admin/template', $data);
    }

    public function create_loan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $results = $this->db->order_by("item_name", "asc")->get_where('items', array('status != ' => 'Trash'))->result();
        $data['itemresults'] = $results;
        $idresults = $this->db->select('loan_no')->from('loans')->limit(1)->order_by('loan_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        if (isset($_POST['submit'])) {
             $check_loanno = $this->db->get_where('loans', array('loan_no' => $_POST['loan_no'], 'status != ' => 'Trash'))->row();
            if (empty($check_loanno)) {
            $data = array('loan_no' => $_POST['loan_no'],
                'loan_date' => $_POST['loan_date'],
                'party_name' => $_POST['party_name'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'adv_interest' => $_POST['adv_interest'],
                'other_charges' => $_POST['other_charges'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
                'name' => implode(',', $_POST['name']),
                'quantity' => $_POST['quantity'],
                'weight' => $_POST['weight'],
                'remark' => $_POST['remark'],
            );
            $this->financemodel->create_loan($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "loans",
                'created_date' => $_POST['loan_date'],
            );
            $this->financemodel->loan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/loan_display', 'refresh');
            }else {
                $this->session->set_flashdata('error', 'Loan No alreday exist!');
            }
        }
        $data['template'] = "admin/create_loan";
        $this->load->view('admin/template', $data);
    }

    public function loan_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("loan_id", "desc")->get_where('loans', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        //$data['doclist'] = $this->sunraymodel->doctor_list();
        $data['template'] = "admin/loan_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_loan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $results = $this->db->order_by("item_name", "asc")->get_where('items', array('status != ' => 'Trash'))->result();
        $data['itemresults'] = $results;
        $loan_id = $this->input->get('loan_id');
        $result = $this->db->get_where("loans", array('loan_id' => $loan_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('loan_no' => $_POST['loan_no'],
                'loan_date' => $_POST['loan_date'],
                'party_name' => $_POST['party_name'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'adv_interest' => $_POST['adv_interest'],
                'other_charges' => $_POST['other_charges'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
                'name' => implode(',', $_POST['name']),
                'quantity' => $_POST['quantity'],
                'weight' => $_POST['weight'],
                'remark' => $_POST['remark'],
            );
            $this->db->where('loan_id', $loan_id);
            $this->db->update('loans', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "loans",
                'created_date' => $_POST['loan_date'],
            );
            $this->db->where('id', $loan_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/loan_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_loan";
        $this->load->view('admin/template', $data);
    }

    public function delete_loan($loan_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("loans", array('loan_id' => $loan_id))->row();
        if (!empty($result)) {
            $this->db->where('loan_id', $loan_id);
            $this->db->update('loans', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/loan_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/loan_display', 'refresh');
        }
    }

    public function view_loan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $loan_id = $this->input->get('loan_id');
        $result = $this->db->get_where("loans", array('loan_id' => $loan_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_loan";
        $this->load->view('admin/template', $data);
    }

    public function create_receipt() {
        $this->checkadmin();
        $idresults = $this->db->select('receipt_no')->from('receipts')->limit(1)->order_by('receipt_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('receipt_no' => $_POST['receipt_no'],
                'receipt_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
                'int_rcvd_upto_dt' => $_POST['int_rcvd_upto_dt'],
                'loan_no' => $_POST['loan_no'],
                'party_name' => $_POST['party_name'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'rcvd_int_amt' => $_POST['rcvd_int_amt'],
                'adv_int_amt' => $_POST['adv_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => $_POST['loan_date'],
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_rcvd_date' => $_POST['last_rcvd_date'],
                'total_days' => $_POST['total_days'],
                'rcvd_loan_amt' => $_POST['rcvd_loan_calc'],
                'rcvd_adv_int' => $_POST['rcvd_adv_int'],
                'bal_loan_amt' => $_POST['bal_loan_calc'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->financemodel->create_receipt($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "receipts",
                'created_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
            );
            $this->financemodel->loan_receipt_data($data);
                       $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/receipt_display', 'refresh');
        }
        $data['template'] = "admin/create_receipt";
        $this->load->view('admin/template', $data);
    }

    public function edit_receipt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $receipt_id = $this->input->get('receipt_id');
        $result = $this->db->get_where("receipts", array('receipt_id' => $receipt_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('receipt_no' => $_POST['receipt_no'],
                'receipt_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
                'int_rcvd_upto_dt' => date('Y-m-d', strtotime($_POST['int_rcvd_upto_dt'])),
                'loan_no' => $_POST['loan_no'],
                'party_name' => $_POST['party_name'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'rcvd_int_amt' => $_POST['rcvd_int_amt'],
                'adv_int_amt' => $_POST['adv_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => date('Y-m-d', strtotime($_POST['loan_date'])),
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_rcvd_date' => date('Y-m-d', strtotime($_POST['last_rcvd_date'])),
                'total_days' => $_POST['total_days'],
                'rcvd_loan_amt' => $_POST['rcvd_loan_calc'],
                'rcvd_adv_int' => $_POST['rcvd_adv_int'],
               'bal_loan_amt' => !empty($_POST['bal_loan_calc']) ? $_POST['bal_loan_calc'] : $_POST['bal_loan_amt'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->db->where('receipt_id', $receipt_id);
            $this->db->update('receipts', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "receipts",
                'created_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
            );
            $this->db->where('id', $receipt_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/receipt_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_receipt";
        $this->load->view('admin/template', $data);
    }

    public function view_receipt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $receipt_id = $this->input->get('receipt_id');
        $result = $this->db->get_where("receipts", array('receipt_id' => $receipt_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_receipt";
        $this->load->view('admin/template', $data);
    }

    public function receipt_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("receipt_id", "desc")->get_where('receipts', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/receipt_display";
        $this->load->view('admin/template', $data);
    }

    public function delete_receipt($receipt_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("receipts", array('receipt_id' => $receipt_id))->row();
        if (!empty($result)) {
            $this->db->where('receipt_id', $receipt_id);
            $this->db->update('receipts', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/receipt_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/receipt_display', 'refresh');
        }
    }

    public function replace_pymt_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $idresults = $this->db->select('pymt_no')->from('replace_payments')->limit(1)->order_by('replace_payment_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        if (isset($_POST['submit'])) {
            $data = array('pymt_no' => $_POST['pymt_no'],
                'pymt_date' => date('Y-m-d', strtotime($_POST['pymt_date'])),
                'int_paid_upto_date' => date('Y-m-d', strtotime($_POST['int_paid_upto_date'])),
                'bank_name' => $_POST['bank_name'],
                'bank_loan_no' => $_POST['bank_loan_no'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'paid_int_amt' => $_POST['paid_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => date('Y-m-d', strtotime($_POST['loan_date'])),
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_paid_date' => date('Y-m-d', strtotime($_POST['last_paid_date'])),
                'paid_loan_amt' => $_POST['rcvd_loan_calc'],
                'bal_loan_amt' => $_POST['bal_loan_calc'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->financemodel->replace_pymt_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "replace_payments",
                'created_date' => $_POST['pymt_date'],
            );
            $this->financemodel->rplloan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/replace_pymt_display', 'refresh');
        }
        $data['template'] = "admin/replace_pymt_create";
        $this->load->view('admin/template', $data);
    }

    public function replace_pymt_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("replace_payment_id", "desc")->get_where('replace_payments', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/replace_pymt_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_rep_pymt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $replace_payment_id = $this->input->get('replace_payment_id');
        $result = $this->db->get_where("replace_payments", array('replace_payment_id' => $replace_payment_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('pymt_no' => $_POST['pymt_no'],
                'pymt_date' => date('Y-m-d', strtotime($_POST['pymt_date'])),
                'int_paid_upto_date' => date('Y-m-d', strtotime($_POST['int_paid_upto_date'])),
                'bank_name' => $_POST['bank_name'],
                'bank_loan_no' => $_POST['bank_loan_no'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'paid_int_amt' => $_POST['paid_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => date('Y-m-d', strtotime($_POST['loan_date'])),
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_paid_date' => date('Y-m-d', strtotime($_POST['last_paid_date'])),
                'paid_loan_amt' => $_POST['rcvd_loan_calc'],
                'bal_loan_amt' => $_POST['bal_loan_calc'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->db->where('replace_payment_id', $replace_payment_id);
            $this->db->update('replace_payments', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "replace_payments",
                'created_date' => date('Y-m-d', strtotime($_POST['pymt_date'])),
            );
            $this->db->where('id', $replace_payment_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/replace_pymt_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_rep_pymt";
        $this->load->view('admin/template', $data);
    }

    public function view_rep_pymt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $replace_payment_id = $this->input->get('replace_payment_id');
        $result = $this->db->get_where("replace_payments", array('replace_payment_id' => $replace_payment_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_rep_pymt";
        $this->load->view('admin/template', $data);
    }

    public function replace_loan_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        $data['nameresults'] = $results;
        $idresults = $this->db->select('sno')->from('replace_loans')->limit(1)->order_by('replaceloan_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        $results = $this->db->order_by("bank_name", "asc")->get_where('banks', array('status != ' => 'Trash'))->result();
        $data['bankresults'] = $results;
        if (isset($_POST['submit'])) {
            $check_bankloanno = $this->db->get_where('replace_loans', array('bank_loan_no' => $_POST['bank_loan_no'], 'status != ' => 'Trash'))->row();
            if (empty($check_bankloanno)) {
            $data = array('sno' => $_POST['sno'],
                'bank_name' => $_POST['bank_name'],
                'date' => date('Y-m-d', strtotime($_POST['date'])),
                'bank_name' => $_POST['bank_name'],
                'bank_loan_no' => $_POST['bank_loan_no'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'other_amt' => $_POST['other_amt'],
                'bal_amt' => $_POST['bal_amt'],
            );
            $this->financemodel->replace_loan_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "replace_loans",
                'created_date' => date('Y-m-d', strtotime($_POST['date'])),
            );
            $this->financemodel->rplloan_data($data);
            $ac_no = array();
            $party_name = array();
            $remark = array();
            if (isset($_POST['ac_no']) && !empty($_POST['ac_no'] != '')) {
                foreach ($_POST['ac_no'] as $key => $ac_no) {
                    $post_data = array('ac_no' => $ac_no, 'replaceloan_id' => $insert_id, 'ac_no' => $_POST['ac_no'][$key], 'remark' => $_POST['remark'][$key], 'party_name' => $_POST['party_name'][$key]);
                    $this->financemodel->rplloan($post_data);
                }
            }
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/replace_loan_display', 'refresh');
            }
             else{
              $this->session->set_flashdata('error', 'Bank Loan No already exist!');    
             }
        }
        $data['template'] = "admin/replace_loan_create";
        $this->load->view('admin/template', $data);
    }

    public function replace_loan_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $get = $this->input->get('date');
        if ($get == '') {
        $results = $this->db->order_by("replaceloan_id", "desc")->get_where('replace_loans', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        }
        else {
            $results = $this->db->order_by("replaceloan_id", "desc")->get_where('replace_loans', array('date<='=>$get,'status !=' => 'Trash'))->result();
        $data['results'] = $results; 
        }
        $data['template'] = "admin/replace_loan_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_rep_loan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $replaceloan_id = $this->input->get('replaceloan_id');
        $result = $this->db->get_where("replace_loans", array('replaceloan_id' => $replaceloan_id))->row();
        $results = $this->db->order_by("bank_name", "asc")->get_where('banks', array('status != ' => 'Trash'))->result();
        $data['bankresults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('sno' => $_POST['sno'],
                'bank_name' => $_POST['bank_name'],
                'date' => date('Y-m-d', strtotime($_POST['date'])),
                'bank_name' => $_POST['bank_name'],
                'bank_loan_no' => $_POST['bank_loan_no'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'other_amt' => $_POST['other_amt'],
                'bal_amt' => $_POST['bal_amt'],
            );
            $this->db->where('replaceloan_id', $replaceloan_id);
            $this->db->update('replace_loans', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "replace_loans",
                'created_date' => date('Y-m-d', strtotime($_POST['date'])),
            );
            $this->db->where('id', $replaceloan_id);
            $this->db->update('group_table', $data);
            $result = $this->db->get_where("replaceloans_additional", array('replaceloan_id' => $replaceloan_id, 'status !=' => 'Trash'))->row();
            if (!empty($result)) {
                $this->db->where('replaceloan_id', $replaceloan_id);
                $this->db->update('replaceloans_additional', array('status' => 'Trash'));
            }
            $ac_no = array();
            $party_name = array();
            $remark = array();
            if (isset($_POST['ac_no']) && !empty($_POST['ac_no'] != '')) {
                foreach ($_POST['ac_no'] as $key => $ac_no) {
                    $post_data = array('ac_no' => $ac_no, 'replaceloan_id' => $replaceloan_id, 'ac_no' => $_POST['ac_no'][$key], 'remark' => $_POST['remark'][$key], 'party_name' => $_POST['party_name'][$key]);
                    $this->financemodel->rplloan($post_data);
                }
            }
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/replace_loan_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_rep_loan";
        $this->load->view('admin/template', $data);
    }

    public function view_rep_loan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $replaceloan_id = $this->input->get('replaceloan_id');
        $result = $this->db->get_where("replace_loans", array('replaceloan_id' => $replaceloan_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_rep_loan";
        $this->load->view('admin/template', $data);
    }
    public function delete_rep_loan($replaceloan_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("replace_loans", array('replaceloan_id' => $replaceloan_id))->row();
        if (!empty($result)) {
            $this->db->where('replaceloan_id', $replaceloan_id);
            $this->db->update('replace_loans', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/replace_loan_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/replace_loan_display', 'refresh');
        }
    }

    public function ploan_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $idresults = $this->db->select('loan_no')->from('personal_loans')->limit(1)->order_by('personal_loan_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        if (isset($_POST['submit'])) {
            $data = array('loan_no' => $_POST['loan_no'],
                'loan_date' => $_POST['loan_date'],
                'party_name' => $_POST['party_name'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'other_charges' => $_POST['other_charges'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
            );
            $this->financemodel->ploan_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "personal_loans",
                'created_date' => $_POST['loan_date'],
            );
            $this->financemodel->ploan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/ploan_display', 'refresh');
        }
        $data['template'] = "admin/ploan_create";
        $this->load->view('admin/template', $data);
    }

    public function ploan_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("personal_loan_id", "desc")->get_where('personal_loans', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ploan_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_ploan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $personal_loan_id = $this->input->get('personal_loan_id');
        $result = $this->db->get_where("personal_loans", array('personal_loan_id' => $personal_loan_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('loan_no' => $_POST['loan_no'],
                'loan_date' => $_POST['loan_date'],
                'party_name' => $_POST['party_name'],
                'loan_amount' => $_POST['loan_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'other_charges' => $_POST['other_charges'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
            );
            $this->db->where('personal_loan_id', $personal_loan_id);
            $this->db->update('personal_loans', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "personal_loans",
                'created_date' => $_POST['loan_date'],
            );
            $this->db->where('id', $personal_loan_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/ploan_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_ploan";
        $this->load->view('admin/template', $data);
    }

    public function delete_ploan($personal_loan_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("personal_loans", array('personal_loan_id' => $personal_loan_id))->row();
        if (!empty($result)) {
            $this->db->where('personal_loan_id', $personal_loan_id);
            $this->db->update('personal_loans', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/ploan_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/ploan_display', 'refresh');
        }
    }

    public function view_ploan() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $personal_loan_id = $this->input->get('personal_loan_id');
        $result = $this->db->get_where("personal_loans", array('personal_loan_id' => $personal_loan_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_ploan";
        $this->load->view('admin/template', $data);
    }

    public function ploan_receipt_create() {
        $this->checkadmin();
        $idresults = $this->db->select('receipt_no')->from('personalloan_receipts')->limit(1)->order_by('receipt_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('receipt_no' => $_POST['receipt_no'],
                'receipt_date' => $_POST['receipt_date'],
                'int_rcvd_upto_date' => $_POST['int_rcvd_upto_date'],
                'loan_no' => $_POST['loan_no'],
                'party_name' => $_POST['party_name'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'rcvd_int_amt' => $_POST['rcvd_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => $_POST['loan_date'],
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_rcvd_date' => $_POST['last_rcvd_date'],
                'total_days' => $_POST['total_days'],
                'rcvd_loan_amt' => $_POST['rcvd_loan_calc'],
                'bal_loan_amt' => $_POST['bal_loan_calc'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->financemodel->ploan_receipt_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "personalloan_receipts",
                'created_date' => $_POST['receipt_date'],
            );
            $this->financemodel->rplloan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/ploan_receipt_display', 'refresh');
        }
        $data['template'] = "admin/ploan_receipt_create";
        $this->load->view('admin/template', $data);
    }

    public function ploan_receipt_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("receipt_id", "desc")->get_where('personalloan_receipts', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ploan_receipt_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_plreceipt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $receipt_id = $this->input->get('receipt_id');
        $result = $this->db->get_where("personalloan_receipts", array('receipt_id' => $receipt_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('receipt_no' => $_POST['receipt_no'],
                'receipt_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
                'int_rcvd_upto_date' => date('Y-m-d', strtotime($_POST['int_rcvd_upto_date'])),
                'loan_no' => $_POST['loan_no'],
                'party_name' => $_POST['party_name'],
                'loan_amt' => $_POST['loan_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'rcvd_int_amt' => $_POST['rcvd_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'loan_date' => date('Y-m-d', strtotime($_POST['loan_date'])),
                'loan_amount' => $_POST['loan_amount'],
                'int_per' => $_POST['int_per'],
                'last_rcvd_date' => date('Y-m-d', strtotime($_POST['last_rcvd_date'])),
                'total_days' => $_POST['total_days'],
                'rcvd_loan_amt' => $_POST['rcvd_loan_calc'],
                'bal_loan_amt' => $_POST['bal_loan_calc'],
                'prebal_calc' => $_POST['prebal_calc'],
            );
            $this->db->where('receipt_id', $receipt_id);
            $this->db->update('personalloan_receipts', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "personalloan_receipts",
                'created_date' => date('Y-m-d', strtotime($_POST['receipt_date'])),
            );
            $this->db->where('id', $receipt_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/ploan_receipt_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_plreceipt";
        $this->load->view('admin/template', $data);
    }

    public function view_plreceipt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $receipt_id = $this->input->get('receipt_id');
        $result = $this->db->get_where("personalloan_receipts", array('receipt_id' => $receipt_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_plreceipt";
        $this->load->view('admin/template', $data);
    }

    public function create_deposit() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('deposit_parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $idresults = $this->db->select('dep_no')->from('deposits')->order_by('deposit_id', 'DESC')->get()->row();
        //print_r($idresults);
        $data['idresults'] = $idresults;
        if (isset($_POST['submit'])) {
            $data = array('dep_no' => $_POST['dep_no'],
                'dep_date' => $_POST['dep_date'],
                'party_name' => $_POST['party_name'],
                'dep_amount' => $_POST['dep_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
            );
            $this->financemodel->create_deposit($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "deposits",
                'created_date' => $_POST['dep_date'],
            );
            $this->financemodel->rplloan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/deposit_display', 'refresh');
        }
        $data['template'] = "admin/create_deposit";
        $this->load->view('admin/template', $data);
    }

    public function deposit_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("deposit_id", "desc")->get_where('deposits', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/deposit_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_deposit() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_name", "asc")->get_where('deposit_parties', array('status != ' => 'Trash'))->result();
        $data['partyresults'] = $results;
        $deposit_id = $this->input->get('deposit_id');
        $result = $this->db->get_where("deposits", array('deposit_id' => $deposit_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('dep_no' => $_POST['dep_no'],
                'dep_date' => $_POST['dep_date'],
                'party_name' => $_POST['party_name'],
                'dep_amount' => $_POST['dep_amount'],
                'interest_per' => $_POST['interest_per'],
                'interest' => $_POST['interest'],
                'pay_from' => $_POST['pay_from'],
                'remarks' => $_POST['remarks'],
            );
            $this->db->where('deposit_id', $deposit_id);
            $this->db->update('deposits', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "deposits",
                'created_date' => $_POST['dep_date'],
            );
            $this->db->where('id', $deposit_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/deposit_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_deposit";
        $this->load->view('admin/template', $data);
    }

    public function delete_deposit($deposit_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("deposits", array('deposit_id' => $deposit_id))->row();
        if (!empty($result)) {
            $this->db->where('deposit_id', $deposit_id);
            $this->db->update('deposits', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/deposit_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/deposit_display', 'refresh');
        }
    }

    public function view_deposit() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $deposit_id = $this->input->get('deposit_id');
        $result = $this->db->get_where("deposits", array('deposit_id' => $deposit_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_deposit";
        $this->load->view('admin/template', $data);
    }

    public function deposit_pymt_create() {
        $this->checkadmin();
        $idresults = $this->db->select('pymt_no')->from('deposit_payments')->limit(1)->order_by('pymt_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('pymt_no' => $_POST['pymt_no'],
                'pymt_date' => $_POST['pymt_date'],
                'int_paid_upto_date' => $_POST['int_paid_upto_date'],
                'dep_no' => $_POST['dep_no'],
                'party_name' => $_POST['party_name'],
                'dep_amt' => $_POST['dep_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'paid_int_amt' => $_POST['paid_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'dep_date' => $_POST['dep_date'],
                'dep_amount' => $_POST['dep_amount'],
                'int_per' => $_POST['int_per'],
                'last_paid_date' => $_POST['last_paid_date'],
                'paid_dep_amt' => $_POST['paid_dep_amt'],
                'bal_dep_amt' => $_POST['bal_dep_amt'],
                'prebal_calc' => $_POST['prebal_calc'],
                'total_dep_amt' => $_POST['total_dep_amt'],
            );
            $this->financemodel->deposit_pymt_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "deposit_payments",
                'created_date' => $_POST['pymt_date'],
            );
            $this->financemodel->rplloan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/deposit_pymt_display', 'refresh');
        }
        $data['template'] = "admin/deposit_pymt_create";
        $this->load->view('admin/template', $data);
    }

    public function deposit_pymt_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("pymt_id", "desc")->get_where('deposit_payments', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/deposit_pymt_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_dep_pymt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $pymt_id = $this->input->get('pymt_id');
        $result = $this->db->get_where("deposit_payments", array('pymt_id' => $pymt_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('pymt_no' => $_POST['pymt_no'],
                'pymt_date' => date('Y-m-d', strtotime($_POST['pymt_date'])),
                'int_paid_upto_date' => date('Y-m-d', strtotime($_POST['int_paid_upto_date'])),
                'dep_no' => $_POST['dep_no'],
                'party_name' => $_POST['party_name'],
                'dep_amt' => $_POST['dep_amt'],
                'int_amt' => $_POST['int_amt'],
                'pre_bal_int_amt' => $_POST['pre_bal_int_amt'],
                'paid_int_amt' => $_POST['paid_int_amt'],
                'add_less' => $_POST['add_less'],
                'total_amt' => $_POST['total_amt'],
                'pay_to' => $_POST['pay_to'],
                'remarks' => $_POST['remarks'],
                'ac_close' => $_POST['ac_close'],
                'dep_date' => date('Y-m-d', strtotime($_POST['dep_date'])),
                'dep_amount' => $_POST['dep_amount'],
                'int_per' => $_POST['int_per'],
                'last_paid_date' => date('Y-m-d', strtotime($_POST['last_paid_date'])),
                'paid_dep_amt' => $_POST['paid_dep_amt'],
                'bal_dep_amt' => $_POST['bal_dep_amt'],
                'prebal_calc' => $_POST['prebal_calc'],
                'total_dep_amt' => $_POST['total_dep_amt'],
            );
            $this->db->where('pymt_id', $pymt_id);
            $this->db->update('deposit_payments', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "deposit_payments",
                'created_date' => date('Y-m-d', strtotime($_POST['pymt_date'])),
            );
            $this->db->where('id', $pymt_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/deposit_pymt_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_dep_pymt";
        $this->load->view('admin/template', $data);
    }

    public function view_dep_pymt() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $pymt_id = $this->input->get('pymt_id');
        $result = $this->db->get_where("deposit_payments", array('pymt_id' => $pymt_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_dep_pymt";
        $this->load->view('admin/template', $data);
    }

    public function voucher_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $date = $this->input->get('date');
        if ($date == '') {
            $tdydate = date('Y-m-d');
            $results = $this->db->order_by("voucher_id", "desc")->get_where('vouchers', array('vch_date' => $tdydate, 'status !=' => 'Trash'))->result();
            $data['results'] = $results;
        } else {
            $getdetails = $this->db->order_by("voucher_id", "asc")->get_where('vouchers', array('vch_date' => $date, 'status !=' => 'Trash'))->result();
            $data['dateresults'] = $getdetails;
        }
        $data['template'] = "admin/voucher_display";
        $this->load->view('admin/template', $data);
    }

    public function voucher_date_filter() {
        $this->load->model('financemodel');
        $dateresults = $this->db->order_by("voucher_id", "desc")->get_where('vouchers', array('vch_date' => $_REQUEST['vch_date'], 'status !=' => 'Trash'))->result();
        $data['dateresults'] = $dateresults;
        echo json_encode($data['dateresults']);
    }

    public function voucher_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        // $results = $this->db->order_by("ledgercat_id")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        //  $n_results = $this->db->order_by("name", "asc")->get_where('ledger', array('status != ' => 'Trash'))->result();
        // if ($n_results != $results) {
        //     $l_results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        //     $data['nameresults'] = $l_results;
        $nl_results = $this->db->order_by("name", "asc")->get_where('ledger', array('status != ' => 'Trash'))->result();
        $data['nl_results'] = $nl_results;
        //}
        $idresults = $this->db->select('vch_no')->from('vouchers')->limit(1)->order_by('voucher_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        if (isset($_POST['submit'])) {
            $data = array('vch_type' => $_POST['vch_type'],
                'vch_no' => $_POST['vch_no'],
                'vch_date' => $_POST['vch_date'],
                'type' => $_POST['type'],
                'particulars' => $_POST['particulars'],
                'credit' => $_POST['credit'],
                'debit' => $_POST['debit'],
                'remarks' => $_POST['remarks'],
                'narration' => $_POST['narration'],
                'under' => $_POST['under'],
            );
            $this->financemodel->voucher_create($data);
            $insert_id = $this->db->insert_id();
            $data = array('id' => $insert_id,
                'table_name' => "vouchers",
                'created_date' => $_POST['vch_date'],
            );
            $this->financemodel->rplloan_data($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/voucher_display', 'refresh');
        }
        $data['template'] = "admin/voucher_create";
        $this->load->view('admin/template', $data);
    }

    public function edit_voucher() {
        $this->checkadmin();
        $this->load->model('financemodel');
        // $results = $this->db->order_by("ledgercat_id")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        //  $n_results = $this->db->order_by("name", "asc")->get_where('ledger', array('status != ' => 'Trash'))->result();
        // if ($n_results != $results) {
        //     $l_results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        //     $data['nameresults'] = $l_results;
        $nl_results = $this->db->order_by("name", "asc")->get_where('ledger', array('status != ' => 'Trash'))->result();
        $data['nl_results'] = $nl_results;
        //}
        $idresults = $this->db->select('vch_no')->from('vouchers')->limit(1)->order_by('voucher_id', 'DESC')->get()->row();
        $data['idresults'] = $idresults;
        $voucher_id = $this->input->get('voucher_id');
        $result = $this->db->get_where("vouchers", array('voucher_id' => $voucher_id))->row();
        //print_r($result);exit;
        if (isset($_POST['submit'])) {
            $data = array('vch_type' => $_POST['vch_type'],
                'vch_no' => $_POST['vch_no'],
                'vch_date' => date('Y-m-d', strtotime($_POST['vch_date'])),
                'type' => $_POST['type'],
                'particulars' => $_POST['particulars'],
                'credit' => $_POST['credit'],
                'debit' => $_POST['debit'],
                'remarks' => $_POST['remarks'],
                'narration' => $_POST['narration'],
                'under' => $_POST['under'],
            );
            $this->db->where('voucher_id', $voucher_id);
            $this->db->update('vouchers', $data);
            $insert_id = $this->db->insert_id();
            $data = array(
                'table_name' => "vouchers",
                'created_date' => date('Y-m-d', strtotime($_POST['vch_date'])),
            );
            $this->db->where('id', $voucher_id);
            $this->db->update('group_table', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/voucher_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_voucher";
        $this->load->view('admin/template', $data);
    }

    public function view_voucher() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $voucher_id = $this->input->get('voucher_id');
        $result = $this->db->get_where("vouchers", array('voucher_id' => $voucher_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_voucher";
        $this->load->view('admin/template', $data);
    }

    public function delete_voucher($voucher_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("vouchers", array('voucher_id' => $voucher_id))->row();
        if (!empty($result)) {
            $this->db->where('voucher_id', $voucher_id);
            $this->db->update('vouchers', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/voucher_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/receipt_display', 'refresh');
        }
    }

//    public function daybook_display() {
//        $this->checkadmin();
//        $this->load->model('financemodel');
//        $date = $this->input->get('date');
//        $tdydate = date('Y-m-d');
//        if (!empty($date)) {
//            $gettables = $this->db->select('*')->order_by("table_id", "asc")->get_where('group_table', array('DATE(created_date)' => $date, 'status !=' => 'Trash'))->result();
//            $data['results'] = $gettables;
//        }
//        if (isset($_POST['submit'])) {
//            $data = array('daybook_date' => $_POST['daybook_date'],
//                'closing_balance' => $_POST['closing_balance'],
//            );
//            $this->financemodel->daybook_display($data);
//            $this->session->set_flashdata('success', 'Closed successfully!');
//            redirect('admin/daybook_display', 'refresh');
//        }
//        $data['template'] = "admin/daybook_display";
//        $this->load->view('admin/template', $data);
//    }
    public function daybook_display() {
        $this->checkadmin();

        $data['template'] = "admin/daybook_display";
        $this->load->view('admin/template', $data);
    }

    public function daybook_date_filter() {
        $this->checkadmin();
        $this->load->model('financemodel');

        $data['template'] = "admin/daybook_display";
        $this->load->view('admin/template', $data);
    }

    public function add_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        $results = $this->db->order_by("reference_name", "asc")->get_where('references', array('status != ' => 'Trash'))->result();
        $data['refnameresults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('party_name' => $_POST['party_name'],
                'party_mobile' => $_POST['party_mobile'],
                'party_address' => $_POST['party_address'],
                'print_name' => $_POST['print_name'],
            );
            $this->financemodel->add_party($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/party_display', 'refresh');
        }
        $data['template'] = "admin/add_party";
        $this->load->view('admin/template', $data);
    }

    public function party_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("party_id", "desc")->get_where('parties', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
//$data['doclist'] = $this->sunraymodel->doctor_list();
        $data['template'] = "admin/party_display";
        $this->load->view('admin/template', $data);
    }

    public function delete_party($party_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("parties", array('party_id' => $party_id))->row();
        if (!empty($result)) {
            $this->db->where('party_id', $party_id);
            $this->db->update('parties', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'User deleted successfully!');
            redirect('admin/party_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/party_display', 'refresh');
        }
    }

    public function edit_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        $results = $this->db->order_by("reference_name", "asc")->get_where('references', array('status != ' => 'Trash'))->result();
        $data['refnameresults'] = $results;
        $party_id = $this->input->get('party_id');
        $result = $this->db->get_where("parties", array('party_id' => $party_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('party_name' => $_POST['party_name'],
                'party_mobile' => $_POST['party_mobile'],
                'party_address' => $_POST['party_address'],
                'print_name' => $_POST['print_name'],
            );
            $this->db->where('party_id', $party_id);
            $this->db->update('parties', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/party_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_party";
        $this->load->view('admin/template', $data);
    }

    public function view_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $party_id = $this->input->get('party_id');
        $result = $this->db->get_where("parties", array('party_id' => $party_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_party";
        $this->load->view('admin/template', $data);
    }

    public function add_dep_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        $results = $this->db->order_by("reference_name", "asc")->get_where('references', array('status != ' => 'Trash'))->result();
        $data['refnameresults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('party_name' => $_POST['party_name'],
                'party_mobile' => $_POST['party_mobile'],
                'party_address' => $_POST['party_address'],
            );
            $this->financemodel->add_dep_party($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/dep_party_display', 'refresh');
        }
        $data['template'] = "admin/add_dep_party";
        $this->load->view('admin/template', $data);
    }

    public function dep_party_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("dep_party_id", "desc")->get_where('deposit_parties', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/dep_party_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_dep_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        $results = $this->db->order_by("reference_name", "asc")->get_where('references', array('status != ' => 'Trash'))->result();
        $data['refnameresults'] = $results;
        $dep_party_id = $this->input->get('dep_party_id');
        $result = $this->db->get_where("deposit_parties", array('dep_party_id' => $dep_party_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('party_name' => $_POST['party_name'],
                'party_mobile' => $_POST['party_mobile'],
                'party_address' => $_POST['party_address'],
                'res_phone' => $_POST['res_phone'],
                'off_phone' => $_POST['off_phone'],
                'area' => $_POST['area'],
                'reference' => $_POST['reference'],
            );
            $this->db->where('dep_party_id', $dep_party_id);
            $this->db->update('deposit_parties', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/dep_party_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_dep_party";
        $this->load->view('admin/template', $data);
    }

    public function delete_dep_party($dep_party_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("deposit_parties", array('dep_party_id' => $dep_party_id))->row();
        if (!empty($result)) {
            $this->db->where('dep_party_id', $dep_party_id);
            $this->db->update('deposit_parties', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'User deleted successfully!');
            redirect('admin/dep_party_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/dep_party_display', 'refresh');
        }
    }

    public function view_dep_party() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $dep_party_id = $this->input->get('dep_party_id');
        $result = $this->db->get_where("deposit_parties", array('dep_party_id' => $dep_party_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_dep_party";
        $this->load->view('admin/template', $data);
    }

    public function area_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('area_name' => $_POST['area_name'],
            );
            $this->financemodel->area_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/area_display', 'refresh');
        }
        $data['template'] = "admin/area_create";
        $this->load->view('admin/template', $data);
    }

    public function area_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("area_id", "desc")->get_where('areas', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/area_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_area() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $area_id = $this->input->get('area_id');
        $result = $this->db->get_where("areas", array('area_id' => $area_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('area_name' => $_POST['area_name'],
            );
            $this->db->where('area_id', $area_id);
            $this->db->update('areas', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/area_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_area";
        $this->load->view('admin/template', $data);
    }

    public function delete_area($area_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("areas", array('area_id' => $area_id))->row();
        if (!empty($result)) {
            $this->db->where('area_id', $area_id);
            $this->db->update('areas', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/area_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/area_display', 'refresh');
        }
    }

    public function view_area() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $area_id = $this->input->get('area_id');
        $result = $this->db->get_where("areas", array('area_id' => $area_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_area";
        $this->load->view('admin/template', $data);
    }

    public function add_bankname() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('bank_name' => $_POST['bank_name'],
            );
            $this->financemodel->add_bankname($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/bank_display', 'refresh');
        }
        $data['template'] = "admin/add_bankname";
        $this->load->view('admin/template', $data);
    }

    public function bank_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("bank_id", "desc")->get_where('banks', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/bank_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_bank() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $bank_id = $this->input->get('bank_id');
        $result = $this->db->get_where("banks", array('bank_id' => $bank_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('bank_name' => $_POST['bank_name'],
            );
            $this->db->where('bank_id', $bank_id);
            $this->db->update('banks', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/bank_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_bank";
        $this->load->view('admin/template', $data);
    }

    public function delete_bank($bank_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("banks", array('bank_id' => $bank_id))->row();
        if (!empty($result)) {
            $this->db->where('bank_id', $bank_id);
            $this->db->update('banks', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/bank_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/bank_display', 'refresh');
        }
    }

    public function view_bank() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $bank_id = $this->input->get('bank_id');
        $result = $this->db->get_where("banks", array('bank_id' => $bank_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_bank";
        $this->load->view('admin/template', $data);
    }

    public function item_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("item_group", "asc")->get_where('item_groups', array('status != ' => 'Trash'))->result();
        $data['itemresults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('item_name' => $_POST['item_name'],
                'group_name' => $_POST['group_name'],
            );
            $this->financemodel->item_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/item_display', 'refresh');
        }
        $data['template'] = "admin/item_create";
        $this->load->view('admin/template', $data);
    }

    public function item_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("item_id", "desc")->get_where('items', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/item_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_item() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("item_group", "asc")->get_where('item_groups', array('status != ' => 'Trash'))->result();
        $data['itemresults'] = $results;
        $item_id = $this->input->get('item_id');
        $result = $this->db->get_where("items", array('item_id' => $item_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('item_name' => $_POST['item_name'],
                'group_name' => $_POST['group_name'],
            );
            $this->db->where('item_id', $item_id);
            $this->db->update('items', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/item_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_item";
        $this->load->view('admin/template', $data);
    }

    public function delete_item($item_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("items", array('item_id' => $item_id))->row();
        if (!empty($result)) {
            $this->db->where('item_id', $item_id);
            $this->db->update('items', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/item_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/item_display', 'refresh');
        }
    }

    public function view_item() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $item_id = $this->input->get('item_id');
        $result = $this->db->get_where("items", array('item_id' => $item_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_item";
        $this->load->view('admin/template', $data);
    }

    public function itemgroup_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('item_group' => $_POST['item_group'],
            );
            $this->financemodel->itemgroup_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/itemgroup_display', 'refresh');
        }
        $data['template'] = "admin/itemgroup_create";
        $this->load->view('admin/template', $data);
    }

    public function itemgroup_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("itemgroup_id", "desc")->get_where('item_groups', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/itemgroup_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_itemgroup() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $itemgroup_id = $this->input->get('itemgroup_id');
        $result = $this->db->get_where("item_groups", array('itemgroup_id' => $itemgroup_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('item_group' => $_POST['item_group'],
            );
            $this->db->where('itemgroup_id', $itemgroup_id);
            $this->db->update('item_groups', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/itemgroup_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_itemgroup";
        $this->load->view('admin/template', $data);
    }

    public function delete_itemgroup($itemgroup_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("item_groups", array('itemgroup_id' => $itemgroup_id))->row();
        if (!empty($result)) {
            $this->db->where('itemgroup_id', $itemgroup_id);
            $this->db->update('item_groups', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/itemgroup_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/itemgroup_display', 'refresh');
        }
    }

    public function view_itemgroup() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $itemgroup_id = $this->input->get('itemgroup_id');
        $result = $this->db->get_where("item_groups", array('itemgroup_id' => $itemgroup_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_itemgroup";
        $this->load->view('admin/template', $data);
    }

    public function reference_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('reference_name' => $_POST['reference_name'],
            );
            $this->financemodel->reference_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/reference_display', 'refresh');
        }
        $data['template'] = "admin/reference_create";
        $this->load->view('admin/template', $data);
    }

    public function reference_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("ref_id", "desc")->get_where('references', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/reference_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_reference() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $ref_id = $this->input->get('ref_id');
        $result = $this->db->get_where("references", array('ref_id' => $ref_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('reference_name' => $_POST['reference_name'],
            );
            $this->db->where('ref_id', $ref_id);
            $this->db->update('references', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/reference_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_reference";
        $this->load->view('admin/template', $data);
    }

    public function delete_reference($ref_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("references", array('ref_id' => $ref_id))->row();
        if (!empty($result)) {
            $this->db->where('ref_id', $ref_id);
            $this->db->update('references', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/reference_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/reference_display', 'refresh');
        }
    }

    public function view_reference() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $ref_id = $this->input->get('ref_id');
        $result = $this->db->get_where("references", array('ref_id' => $ref_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_reference";
        $this->load->view('admin/template', $data);
    }

    public function ledger_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        $data['nameresults'] = $results;
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('name' => $_POST['name'],
                'print_name' => $_POST['print_name'],
                'alias_name' => $_POST['alias_name'],
                'under' => $_POST['under'],
            );
            $this->financemodel->ledger_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/ledger_display', 'refresh');
        }
        $data['template'] = "admin/ledger_create";
        $this->load->view('admin/template', $data);
    }

    public function ledger_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("ledger_id", "desc")->get_where('ledger', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ledger_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_ledger() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        $data['nameresults'] = $results;
        $results = $this->db->order_by("area_name", "asc")->get_where('areas', array('status != ' => 'Trash'))->result();
        $data['arearesults'] = $results;
        $ledger_id = $this->input->get('ledger_id');
        $result = $this->db->get_where("ledger", array('ledger_id' => $ledger_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('name' => $_POST['name'],
                'print_name' => $_POST['print_name'],
                'alias_name' => $_POST['alias_name'],
                'under' => $_POST['under'],
            );
            $this->db->where('ledger_id', $ledger_id);
            $this->db->update('ledger', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/ledger_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_ledger";
        $this->load->view('admin/template', $data);
    }

    public function delete_ledger($ledger_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("ledger", array('ledger_id' => $ledger_id))->row();
        if (!empty($result)) {
            $this->db->where('ledger_id', $ledger_id);
            $this->db->update('ledger', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/ledger_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/ledger_display', 'refresh');
        }
    }

    public function view_ledger() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $ledger_id = $this->input->get('ledger_id');
        $result = $this->db->get_where("ledger", array('ledger_id' => $ledger_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_ledger";
        $this->load->view('admin/template', $data);
    }

    public function create_ledger_grp() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("group_name", "asc")->get_where('ledger_group', array('status != ' => 'Trash'))->result();
        $data['nameresults'] = $results;
        if (isset($_POST['submit'])) {
            $data = array('group_name' => $_POST['group_name'],
                'under' => $_POST['under'],
            );
            $this->financemodel->create_ledger_grp($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/ledger_grp_display', 'refresh');
        }
        $data['template'] = "admin/create_ledger_grp";
        $this->load->view('admin/template', $data);
    }

    public function ledger_grp_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("group_name", "asc")->get_where('ledger_group', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
// print_r($results);exit;
        $data['template'] = "admin/ledger_grp_display";
        $this->load->view('admin/template', $data);
    }

    public function edit_ledgergrp() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status != ' => 'Trash'))->result();
        $data['nameresults'] = $results;
        $ledger_grp_id = $this->input->get('ledger_grp_id');
        $result = $this->db->get_where("ledger_group", array('ledger_grp_id' => $ledger_grp_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('group_name' => $_POST['group_name'],
                'under' => $_POST['under'],
            );
            $this->db->where('ledger_grp_id', $ledger_grp_id);
            $this->db->update('ledger_group', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/ledger_grp_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_ledgergrp";
        $this->load->view('admin/template', $data);
    }

    public function delete_ledgergrp($ledger_grp_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("ledger_group", array('ledger_grp_id' => $ledger_grp_id))->row();
        if (!empty($result)) {
            $this->db->where('ledger_grp_id', $ledger_grp_id);
            $this->db->update('ledger_group', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/ledger_grp_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/ledger_grp_display', 'refresh');
        }
    }

    public function view_ledgergrp() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $ledger_grp_id = $this->input->get('ledger_grp_id');
        $result = $this->db->get_where("ledger_group", array('ledger_grp_id' => $ledger_grp_id))->row();
        $data['result'] = $result;
        $data['template'] = "admin/view_ledgergrp";
        $this->load->view('admin/template', $data);
    }

    public function ledger_category() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("name", "asc")->get_where('ledger_categories', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ledger_category";
        $this->load->view('admin/template', $data);
    }

    public function add_ledgercategory() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('name' => $_POST['name'],
            );
            $this->financemodel->add_ledgercategory($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/ledger_category', 'refresh');
        }
        $data['template'] = "admin/add_ledgercategory";
        $this->load->view('admin/template', $data);
    }

    public function edit_ledgercategory() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $ledgercat_id = $this->input->get('ledgercat_id');
        $result = $this->db->get_where("ledger_categories", array('ledgercat_id' => $ledgercat_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('name' => $_POST['name'],
            );
            $this->db->where('ledgercat_id', $ledgercat_id);
            $this->db->update('ledger_categories', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/ledger_category");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_ledgercategory";
        $this->load->view('admin/template', $data);
    }

    public function delete_ledgercategory($ledgercat_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("ledger_categories", array('ledgercat_id' => $ledgercat_id))->row();
        if (!empty($result)) {
            $this->db->where('ledgercat_id', $ledgercat_id);
            $this->db->update('ledger_categories', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/ledger_category', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/ledger_category', 'refresh');
        }
    }

    public function trialbalance() {
        $this->checkadmin();
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $details = $this->db->select('*')->group_by("under")->get_where('ledger', array('under!=' => 'Bank OD Account', 'status !=' => 'Trash'))->result();
        $data['details'] = $details;
        $results = $this->db->select('*')->group_by("particulars")->get_where('vouchers', array('under' => '', 'status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $bankdetails = $this->db->select('*')->select_sum('loan_amount')->group_by("bank_name")->get_where('replace_loans', array('status !=' => 'Trash'))->result();
        $data['bankdetails'] = $bankdetails;
        /* All loans */
        $loan = $this->db->select('loan_amount')->select_sum('loan_amount')->get_where('loans', array('status !=' => 'Trash'))->row();
        $data['loan'] = $loan;
        $loanrec = $this->db->select_sum('loan_amt')->get_where('receipts', array('status !=' => 'Trash'))->row();
        $data['loanrec'] = $loanrec;
        $ploans = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('status !=' => 'Trash'))->row();
        $data['ploan'] = $ploans;
        $plrec = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('status !=' => 'Trash'))->row();
        $data['ploanrec'] = $plrec;
        $deposits = $this->db->select_sum('dep_amount')->get_where('deposits', array('status !=' => 'Trash'))->row();
        $data['dep'] = $deposits;
        $deprec = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('status !=' => 'Trash'))->row();
        $data['deppay'] = $deprec;
        $reprec = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->row();
        $data['reppay'] = $reprec;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $data['template'] = "admin/trialbalance";
        $this->load->view('admin/template', $data);
    }

    public function trialbalance_search() {
        $this->checkadmin();
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $details = $this->db->select('*')->group_by("under")->get_where('ledger', array('under!=' => 'Bank OD Account', 'status !=' => 'Trash'))->result();
        $data['details'] = $details;
        $results = $this->db->select('*')->group_by("particulars")->get_where('vouchers', array('under' => '', 'vch_date>=' => $from, 'vch_date<=' => $to, 'status !=' => 'Trash'))->result();
//print_r($results);
        $data['results'] = $results;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to,'receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to,'receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>=' => $from, 'date<=' => $to, 'date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $bankdetails = $this->db->select('*')->select_sum('loan_amount')->group_by("bank_name")->get_where('replace_loans', array('date>=' => $from, 'date<=' => $to, 'status !=' => 'Trash'))->result();
        $data['bankdetails'] = $bankdetails;
        /* All loans */
        $loan = $this->db->select('loan_amount')->select_sum('loan_amount')->get_where('loans', array('loan_date>=' => $from, 'loan_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['loan'] = $loan;
        $loanrec = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to,'status !=' => 'Trash'))->row();
        $data['loanrec'] = $loanrec;
        $ploans = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date>=' => $from, 'loan_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['ploan'] = $ploans;
        $plrec = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['ploanrec'] = $plrec;
        $deposits = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date>=' => $from, 'dep_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['dep'] = $deposits;
        $deprec = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['deppay'] = $deprec;
        $reprec = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
        $data['reppay'] = $reprec;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>=' => $from, 'date<=' => $to, 'date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $data['template'] = "admin/trialbalance";
        $this->load->view('admin/template', $data);
    }

    public function balance_sheet() {
        $this->checkadmin();
        $this->load->helper('app_helper');
        $details = $this->db->select('*')->group_by("under")->get_where('ledger', array('under !=' => 'Direct Expenses', 'under!=' => 'Direct Incomes', 'status !=' => 'Trash'))->result();
        $data['details'] = $details;
        $bankdetails = $this->db->select('*')->select_sum('loan_amount')->group_by("bank_name")->get_where('replace_loans', array('status !=' => 'Trash'))->result();
        $data['bankdetails'] = $bankdetails;
        $loan = $this->db->select('loan_amount')->select_sum('loan_amount')->get_where('loans', array('status !=' => 'Trash'))->row();
        $data['loan'] = $loan;
        $loanrec = $this->db->select_sum('loan_amt')->get_where('receipts', array('status !=' => 'Trash'))->row();
        $data['loanrec'] = $loanrec;
        $ploans = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('status !=' => 'Trash'))->row();
        $data['ploan'] = $ploans;
        $plrec = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('status !=' => 'Trash'))->row();
        $data['ploanrec'] = $plrec;
        $deposits = $this->db->select_sum('dep_amount')->get_where('deposits', array('status !=' => 'Trash'))->row();
        $data['dep'] = $deposits;
        $deprec = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('status !=' => 'Trash'))->row();
        $data['deppay'] = $deprec;
        $reprec = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->row();
        $data['reppay'] = $reprec;
        /* Profit Loss */
        $detailss = $this->db->group_by('particulars')->get_where('vouchers', array('vch_date>'=>'2019-03-31','under' => 'Direct Expenses', 'particulars !=' => "46", 'status !=' => 'Trash'))->result();
        $data['detailss'] = $detailss;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        //$data['template'] = "admin/profit_loss";
        $data['template'] = "admin/balance_sheet";
        $this->load->view('admin/template', $data);
    }

    public function balance_sheet_search() {
        $this->checkadmin();
        $to = $this->input->get('to');
        $this->load->helper('app_helper');
        $details = $this->db->select('*')->group_by("under")->get_where('ledger', array('under !=' => 'Direct Expenses', 'under!=' => 'Direct Incomes', 'status !=' => 'Trash'))->result();
        $data['details'] = $details;
        $bankdetails = $this->db->select('*')->select_sum('loan_amount')->group_by("bank_name")->get_where('replace_loans', array('date<=' => $to, 'status !=' => 'Trash'))->result();
        $data['bankdetails'] = $bankdetails;
        $loan = $this->db->select('loan_amount')->select_sum('loan_amount')->get_where('loans', array('loan_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['loan'] = $loan;
        $loanrec = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['loanrec'] = $loanrec;
        $ploans = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['ploan'] = $ploans;
        $plrec = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['ploanrec'] = $plrec;
        $deposits = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['dep'] = $deposits;
        $deprec = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
        $data['deppay'] = $deprec;
        $reprec = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
        $data['reppay'] = $reprec;
        /* Profit Loss */
        $detailss = $this->db->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to,'vch_date>'=>'2019-03-31', 'under' => 'Direct Expenses', 'particulars !=' => "46", 'status !=' => 'Trash'))->result();
        $data['detailss'] = $detailss;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date<=' => $to, 'date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date<=' => $to,'receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $to,'receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $data['template'] = "admin/balance_sheet";
        $this->load->view('admin/template', $data);
    }

    public function profit_loss() {
        $this->checkadmin();
        $array = array('under' => 'Direct Expenses', 'particulars !=' => "46");
        $details = $this->db->group_by('particulars')->get_where('vouchers', $array)->result();
        $data['details'] = $details;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31','status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $data['template'] = "admin/profit_loss";
        $this->load->view('admin/template', $data);
    }

    public function profloss_search() {
        $this->checkadmin();
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $details = $this->db->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>' => '2019-03-31', 'under' => 'Direct Expenses', 'particulars !=' => "46", 'status !=' => 'Trash'))->result();
        $data['details'] = $details;
        $commission = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>=' => $from, 'date<=' => $to, 'date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commission'] = $commission;
        $paidint = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $loanint = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to,'receipt_date>' => '2019-03-31',  'status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to,'receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $data['template'] = "admin/profit_loss";
        $this->load->view('admin/template', $data);
    }

    public function ledger_voucher() {
        $this->checkadmin();
        $nl_results = $this->db->order_by("name", "asc")->get_where('ledger', array('status != ' => 'Trash'))->result();
        $data['nl_results'] = $nl_results;
        $data['template'] = "admin/ledger_voucher";
        $this->load->view('admin/template', $data);
    }

    public function ledger_voucher_display() {
        $this->checkadmin();
        $name = $this->input->get('name');
        $vch_details = $this->db->order_by("voucher_id", "asc")->get_where('vouchers', array('particulars' => $name, 'status !=' => 'Trash'))->result();
        $data['vch_details'] = $vch_details;
        $data['template'] = "admin/ledger_voucher_display";
        $this->load->view('admin/template', $data);
    }

    public function inv_setup() {
        $this->checkadmin();
        $data['template'] = "admin/inv_setup";
        $this->load->view('admin/template', $data);
    }

    public function general_setup() {
        $this->checkadmin();
        $data['template'] = "admin/general_setup";
        $this->load->view('admin/template', $data);
    }

    public function ac_closed_list() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("receipt_id", "desc")->get_where('receipts', array('ac_close' => 'Yes', 'status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ac_closed_list";
        $this->load->view('admin/template', $data);
    }

    public function replace_closed_list() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("replace_payment_id", "desc")->get_where('replace_payments', array('ac_close' => 'Yes', 'status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/replace_closed_list";
        $this->load->view('admin/template', $data);
    }

    public function ploan_closed_list() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("receipt_id", "desc")->get_where('personalloan_receipts', array('ac_close' => 'Yes', 'status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ploan_closed_list";
        $this->load->view('admin/template', $data);
    }

    public function deposit_closed_list() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("pymt_id", "desc")->get_where('deposit_payments', array('ac_close' => 'Yes', 'status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/deposit_closed_list";
        $this->load->view('admin/template', $data);
    }

    public function loan_pending() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $get = $this->input->get('date');
        if ($get == '') {
            $results = $this->db->order_by("loan_no", "asc")->get_where('loans', array('status !=' => 'Trash'))->result();
            $data['results'] = $results;
        } else {
            $results = $this->db->order_by("loan_no", "asc")->get_where('loans', array('loan_date<=' => $get, 'status !=' => 'Trash'))->result();
            $data['results'] = $results;
        }
        $data['template'] = "admin/loan_pending";
        $this->load->view('admin/template', $data);
    }

    public function replace_pending() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $date = $this->input->get('date');
        if ($date == '') {
            $results = $this->db->order_by("date", "asc")->get_where('replace_loans', array('status !=' => 'Trash'))->result();
            $data['results'] = $results;
        } else {
            $results = $this->db->order_by("date", "asc")->get_where('replace_loans', array('status !=' => 'Trash'))->result();
            $data['results'] = $results;
        }
        $data['template'] = "admin/replace_pending";
        $this->load->view('admin/template', $data);
    }

    public function ploan_pending() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("loan_date", "asc")->get_where('personal_loans', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/ploan_pending";
        $this->load->view('admin/template', $data);
    }

    public function deposit_pending() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("dep_date", "asc")->get_where('deposits', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        $data['template'] = "admin/deposit_pending";
        $this->load->view('admin/template', $data);
    }

    public function checkadmin() {
        $checkuser = $this->session->userdata('admin_id');
        if (!isset($checkuser) && empty($checkuser)) {
            $this->session->set_flashdata('error', 'Your session expired!');
            redirect('admin/login', 'refresh');
        }
    }

    public function search_loan() {
        $this->load->model('financemodel');
        $party_name = $this->input->post('search');
        if (isset($party_name) and ! empty($party_name)) {
            $data['loans'] = $this->financemodel->search_loan($party_name);
            $this->load->view('admin/loan_display', $data);
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        $this->session->set_flashdata('error', 'Logout Successfully!');
        redirect('admin/login', 'refresh');
    }

    public function show_data() {
        $this->load->model('financemodel');
        $check = $this->db->get_where('receipts', array('loan_no' => $_REQUEST['loan_no']))->row();
        if ($check == '') {
            $results = $this->db->get_where('loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $date2 = date_create($results->loan_date);
            $date1 = date_create($_REQUEST['receipt_date']);
            $diff = date_diff($date2, $date1);
            $calc = ($results->interest / 30);
            $cal = $calc * ($diff->format("%R%a"));
            $int = ceil($cal);
            $array['total_days'] = $diff->format("%R%a");
            $getname = $this->db->get_where('parties', array('party_id' => $results->party_name, 'status != ' => 'Trash'))->row();
            $array['party_name'] = $getname->party_name;
            $array['loan_amt'] = $results->loan_amount;
            $array['int_amt'] = $int;
            $array['adv_int'] = $results->adv_interest;
            $array['adv_interest'] = $results->adv_interest;
            $array['int_amount'] = $int;
            $array['total_amt'] = $results->loan_amount;
            $array['loan_date'] = $results->loan_date;
            $array['loan_amount'] = $results->loan_amount;
            $array['int_per'] = $results->interest_per;
            $array['bal_loan_amt'] = $results->loan_amount;
            $array['pre_bal_int_amt'] = 0;
            $array['pre_bal_int_amount'] = 0;
            $array['rcvd_loan_amt'] = 0;
            $array['rcvd_adv_int'] = 0;
            $today_date = date('Y-m-d');
            $array['last_rcvd_date'] = $_REQUEST['receipt_date'];
            echo json_encode($array);
        } else {
            $details = $this->db->order_by("receipt_date", "desc")->get_where('receipts', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $check = $this->db->select_sum('loan_amt')->get_where('receipts', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->result();
            $date2 = date_create($details->receipt_date);
            $date1 = date_create($_REQUEST['receipt_date']);
            $diff = date_diff($date2, $date1);
            $results = $this->db->get_where('loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $bal = $details->loan_amount - $check[0]->loan_amt;
            $int_calc = ($bal * ($details->int_per) * 30) / 36000;
            $int_per_day = $int_calc / 30;
            $int = $int_per_day * ($diff->format("%R%a"));
            $interest = ceil($int);
            if ($details->prebal_calc == 0) {
                $array['pre_bal_int_amt'] = 0;
                $array['pre_bal_int_amount'] = 0;
            } else {
                $array['pre_bal_int_amt'] = $details->prebal_calc;
                $array['pre_bal_int_amount'] = $details->prebal_calc;
            }
            $array['party_name'] = $details->party_name;
            $array['loan_amt'] = $bal;
            $array['int_amt'] = $interest;
            $array['adv_int'] = $details->adv_int_amt;
            $array['total_amt'] = $bal;
            $array['loan_date'] = $details->loan_date;
            $array['loan_amount'] = $details->loan_amount;
            $array['int_per'] = $details->int_per;
            $array['last_rcvd_date'] = $details->receipt_date;
            $array['adv_interest'] = $details->adv_int_amt;
            $array['total_days'] = $diff->format("%R%a");
            $array['int_amount'] = $interest;
            $array['rcvd_loan_amt'] = $check[0]->loan_amt;
            $array['rcvd_adv_int'] = $details->rcvd_adv_int;
            $array['bal_loan_amt'] = $bal;
            echo json_encode($array);
        }
    }

    public function ploanrecpt_showdata() {
        $this->load->model('financemodel');
        $check = $this->db->get_where('personalloan_receipts', array('loan_no' => $_REQUEST['loan_no']))->row();
        if ($check == '') {
            $results = $this->db->get_where('personal_loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $date2 = date_create($results->loan_date);
            $date1 = date_create($_REQUEST['loan_date']);
            $diff = date_diff($date2, $date1);
            $calc = ($results->interest / 30);
            $cal = $calc * ($diff->format("%R%a"));
            $int = ceil($cal);
            $getname = $this->db->get_where('parties', array('party_id' => $results->party_name, 'status != ' => 'Trash'))->row();
            $array['party_name'] = $getname->party_name;
            $array['loan_amt'] = $results->loan_amount;
            $array['int_amt'] = $int;
            $array['int_amount'] = $int;
            $array['loan_date'] = $results->loan_date;
            $today_date = date('Y-m-d');
            $array['last_rcvd_date'] = $today_date;
            $array['loan_amount'] = $results->loan_amount;
            $array['total_amt'] = $results->loan_amount;
            $array['bal_loan_amt'] = $results->loan_amount;
            $array['int_per'] = $results->interest_per;
            $array['total_days'] = $diff->format("%R%a");
            $array['rcvd_loan_amt'] = 0;
            $array['pre_bal_int_amt'] = 0;
            $array['pre_bal_int_amount'] = 0;
            echo json_encode($array);
        } else {
            $details = $this->db->order_by("receipt_date", "desc")->get_where('personalloan_receipts', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $check = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->result();
            $date2 = date_create($details->receipt_date);
            $date1 = date_create($_REQUEST['loan_date']);
            $diff = date_diff($date2, $date1);
            $results = $this->db->get_where('personal_loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
            $bal = $details->loan_amount - $check[0]->loan_amt;
            $int_calc = ($bal * ($details->int_per) * 30) / 36000;
            $int_per_day = $int_calc / 30;
            $int = $int_per_day * ($diff->format("%R%a"));
            $interest = ceil($int);
            if ($details->prebal_calc == 0) {
                $array['pre_bal_int_amt'] = 0;
                $array['pre_bal_int_amount'] = 0;
            } else {
                $array['pre_bal_int_amt'] = $details->prebal_calc;
                $array['pre_bal_int_amount'] = $details->prebal_calc;
            }
            $array['party_name'] = $details->party_name;
            $array['loan_amt'] = $bal;
            $array['int_amt'] = $interest;
            $array['total_amt'] = $bal;
            $array['loan_date'] = $details->loan_date;
            $array['loan_amount'] = $details->loan_amount;
            $array['int_per'] = $details->int_per;
            $array['last_rcvd_date'] = $details->receipt_date;
            $array['adv_int_amt'] = $details->adv_int_amt;
            $array['total_days'] = $diff->format("%R%a");
            $array['int_amount'] = $interest;
            $array['rcvd_loan_amt'] = $check[0]->loan_amt;
            $array['bal_loan_amt'] = $bal;
            echo json_encode($array);
        }
    }

    public function deposit_showdata() {
        $this->load->model('financemodel');
        $check = $this->db->get_where('deposit_payments', array('dep_no' => $_REQUEST['dep_no']))->row();
        if ($check == '') {
            $results = $this->db->get_where('deposits', array('dep_no' => $_REQUEST['dep_no'], 'status != ' => 'Trash'))->row();
            $date2 = date_create($results->dep_date);
            $date1 = date_create(date('Y-m-d'));
            $diff = date_diff($date2, $date1);
            $calc = ($results->interest / 30);
            $cal = $calc * ($diff->format("%R%a"));
            $int = ceil($cal);
            $total_amt = $results->dep_amount + $int;
            $getname = $this->db->get_where('deposit_parties', array('dep_party_id' => $results->party_name, 'status != ' => 'Trash'))->row();
            $array['dep_date'] = $results->dep_date;
            $array['party_name'] = $getname->party_name;
            $array['dep_amt'] = $results->dep_amount;
            $array['int_amt'] = $int;
            $array['paid_int_amt'] = $int;
            $array['total_amt'] = $total_amt;
            $array['dep_amount'] = $results->dep_amount;
            $array['int_per'] = $results->interest_per;
            $array['int_amount'] = $int;
            $array['total_days'] = $diff->format("%R%a");
            $array['bal_dep_amt'] = $results->dep_amount;
            $array['pre_bal_int_amt'] = 0;
            $array['pre_bal_int_amount'] = 0;
            $array['paid_dep_amt'] = 0;
            $today_date = date('Y-m-d');
            $array['last_paid_date'] = $today_date;
            $array['total_dep_amt'] = $results->dep_amount;
            echo json_encode($array);
        } else {
            $details = $this->db->order_by("pymt_date", "desc")->get_where('deposit_payments', array('dep_no' => $_REQUEST['dep_no'], 'status != ' => 'Trash'))->row();
            $check = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('dep_no' => $_REQUEST['dep_no'], 'status != ' => 'Trash'))->result();
            $date2 = date_create($details->pymt_date);
            $date1 = date_create(date('Y-m-d'));
            $diff = date_diff($date2, $date1);
            $results = $this->db->get_where('deposits', array('dep_no' => $_REQUEST['dep_no'], 'status != ' => 'Trash'))->row();
            $bal = $details->bal_dep_amt + $check[0]->dep_amt;
            $calc = ($results->interest / 30);
            $cal = $calc * ($diff->format("%R%a"));
            $int = ceil($cal);
            $array['party_name'] = $details->party_name;
            $array['dep_amt'] = $bal;
            $array['int_amt'] = $int;
            $array['paid_int_amt'] = $int;
            $array['pre_bal_int_amt'] = $details->pre_bal_int_amt;
            $array['pre_bal_int_amount'] = $details->pre_bal_int_amt;
            $array['total_amt'] = $bal;
            $array['dep_date'] = $details->dep_date;
            $array['dep_amount'] = $details->dep_amount;
            $array['int_per'] = $details->int_per;
            $array['last_paid_date'] = $details->pymt_date;
            $array['total_days'] = $diff->format("%R%a");
            $array['int_amount'] = $int;
            $array['paid_dep_amt'] = $details->paid_dep_amt;
            $array['bal_dep_amt'] = $bal;
            $array['total_dep_amt'] = $bal;
            echo json_encode($array);
        }
    }

    public function replacepymt_show_data() {
        $this->load->model('financemodel');
        $check = $this->db->get_where('replace_payments', array('bank_loan_no' => $_REQUEST['bank_loan_no']))->row();
        if ($check == '') {
            $results = $this->db->get_where('replace_loans', array('bank_loan_no' => $_REQUEST['bank_loan_no'], 'status != ' => 'Trash'))->row();
            $date2 = date_create($results->date);
            $date1 = date_create($_REQUEST['pymt_date']);
            $diff = date_diff($date2, $date1);
            $calc = ($results->interest / 30);
            $cal = $calc * ($diff->format("%R%a"));
            $int = ceil($cal);
            $getbank = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $results->bank_name))->row();
            //print_r($getbank);exit;
            $array['bank_name'] = $getbank->bank_name;
            $array['loan_amt'] = $results->loan_amount;
            $array['int_amt'] = $int;
            $array['int_amount'] = $int;
            $array['loan_date'] = $results->date;
            $array['loan_amount'] = $results->loan_amount;
            $array['total_amt'] = $results->loan_amount;
            $array['bal_loan_amt'] = $results->loan_amount;
            $array['int_per'] = $results->interest_per;
            $array['total_days'] = $diff->format("%R%a");
            $array['pre_bal_int_amt'] = 0;
            $array['pre_bal_int_amount'] = 0;
            $array['paid_loan_amt'] = 0;
            $today_date = date('Y-m-d');
            $array['last_paid_date'] = $_REQUEST['pymt_date'];
            echo json_encode($array);
        } else {
            $details = $this->db->order_by("pymt_date", "desc")->get_where('replace_payments', array('bank_loan_no' => $_REQUEST['bank_loan_no'], 'status != ' => 'Trash'))->row();
            $check = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('bank_loan_no' => $_REQUEST['bank_loan_no'], 'status != ' => 'Trash'))->result();
            $date2 = date_create($details->pymt_date);
            $date1 = date_create($_REQUEST['pymt_date']);
            $diff = date_diff($date2, $date1);
            $results = $this->db->get_where('replace_loans', array('bank_loan_no' => $_REQUEST['bank_loan_no'], 'status != ' => 'Trash'))->row();
            $bal = $details->loan_amount - $check[0]->loan_amt;
            $int_calc = ($bal * ($details->int_per) * 30) / 36000;
            $int_per_day = $int_calc / 30;
            $int = $int_per_day * ($diff->format("%R%a"));
            $interest = ceil($int);
            if ($details->prebal_calc == 0) {
                $array['pre_bal_int_amt'] = 0;
                $array['pre_bal_int_amount'] = 0;
            } else {
                $array['pre_bal_int_amt'] = $details->prebal_calc;
                $array['pre_bal_int_amount'] = $details->prebal_calc;
            }
            $getbank = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $details->bank_name))->row();
            $array['bank_name'] = $getbank->bank_name;
            $array['loan_amt'] = $bal;
            $array['int_amt'] = $interest;
            $array['total_amt'] = $bal;
            $array['loan_date'] = $details->loan_date;
            $array['loan_amount'] = $details->loan_amount;
            $array['int_per'] = $details->int_per;
            $array['last_paid_date'] = $details->pymt_date;
            $array['total_days'] = $diff->format("%R%a");
            $array['int_amount'] = $interest;
            $array['paid_loan_amt'] = $check[0]->loan_amt;
            $array['bal_loan_amt'] = $bal;
            echo json_encode($array);
        }
    }

    public function replaceloan_show_data() {
        $this->load->model('financemodel');
        $results = $this->db->get_where('loans', array('loan_no' => $_REQUEST['ac_no'], 'status != ' => 'Trash'))->row();
        $getname = $this->db->get_where('parties', array('party_id' => $results->party_name, 'status != ' => 'Trash'))->row();
        $array['party_name'] = $getname->party_name;
        $array['remark'] = $results->remark;
        echo json_encode($array);
    }

    public function view_details() {
        $this->load->model('financemodel', "a");
//$this->load->view("view_details"); 
        $voucher_id = $this->input->get('voucher_id');
        if ($voucher_id == "cash_a/c") {
            $query = '(SELECT `loan_date` AS DATES,SUM(`loan_amount`) as AMOUNT,"loans" as TABLES FROM loans  WHERE status != "Trash"  GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `loan_date` AS DATES,SUM(`loan_amount`) as AMOUNT,"personal_loans" as TABLES FROM personal_loans  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('M,Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
            $get_tot_from_loans = $this->db->order_by('loan_date', "asc")->select('SUM(`loan_amount`) as loan_amount,MONTH(loan_date) as month,Year(loan_date) as year')->group_by('MONTH(loan_date)', 'YEAR(loan_date)')->get_where('loans', array('status !=' => 'Trash'))->result();
            $get_tot_from_ploans = $this->db->order_by('loan_date', "asc")->select('SUM(`loan_amount`)')->group_by('MONTH(loan_date)')->get_where('personal_loans', array('status !=' => 'Trash'))->result();
            $get_tot_from_rploans = $this->db->order_by('replaceloan_id')->select('date', 'bal_amt')->get_where('replace_loans', array('status !=' => 'Trash'))->result();
            $get_tot_from_deposits = $this->db->order_by('deposit_id')->select('dep_date', 'dep_amount')->get_where('deposits', array('status !=' => 'Trash'))->result();
            $get_tot_from_recpt = $this->db->select('receipt_date', 'total_amt')->get_where('receipts', array('status !=' => 'Trash'))->result();
            $get_tot_from_precpt = $this->db->select('receipt_date', 'total_amt')->get_where('personalloan_receipts', array('status !=' => 'Trash'))->result();
            $get_tot_from_deppay = $this->db->select('pymt_date', 'dep_amt')->get_where('deposit_payments', array('status !=' => 'Trash'))->result();
            $get_tot_from_reppay = $this->db->select('pymt_date', 'total_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->result();
            $get_ctot_from_voucher = $this->db->select('vch_date', 'credit')->get_where('vouchers', array('status !=' => 'Trash'))->result();
            $get_dtot_from_voucher = $this->db->select('vch_date', 'debit')->get_where('vouchers', array('status !=' => 'Trash'))->result();
            $get_inttot_from_deppay = $this->db->select('pymt_date', 'paid_int_amt')->get_where('deposit_payments', array('status !=' => 'Trash'))->result();
        } else if ($voucher_id == "Interest Received") {
            $query = '(SELECT `receipt_date` AS DATES,SUM(`rcvd_int_amt`) as AMOUNT,"receipts" as TABLES FROM receipts  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`rcvd_int_amt`) as AMOUNT,"personalloan_receipts" as TABLES FROM personalloan_receipts  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `vch_date` AS DATES,SUM(`credit`) as AMOUNT,"vouchers" as TABLES FROM vouchers WHERE  status != "Trash",`particulars`=`48` GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('M,Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
        } else {
            $getdetails = $this->db->select('vch_date')->order_by('vch_date', "asc")->group_by('MONTH(vch_date), YEAR(vch_date)')->get_where("vouchers", array('particulars' => $voucher_id, 'status !=' => 'Trash'))->result();
            $data['getdetails'] = $getdetails;
        }
        $data['template'] = "admin/view_details";
        $this->load->view('admin/template', $data);
    }

    public function view_vch_details() {
        $this->load->model('financemodel', "a");
        $voucher_id = $this->input->get('voucher_id');
        $id = $this->input->get('id');
        if ($voucher_id == "cash_a/c") {
            $query = '(SELECT `loan_date` AS DATES,SUM(`loan_amount`) as DEBIT,"loans" as TABLES FROM loans  WHERE loan_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `loan_date` AS DATES,SUM(`loan_amount`) as DEBIT,"personal_loans" as TABLES FROM personal_loans  WHERE loan_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`total_amt`) as DEBIT,"replace_payments" as TABLES FROM replace_payments  WHERE pymt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `dep_date` AS DATES,SUM(`dep_amount`) as CREDIT,"deposits" as TABLES FROM deposits  WHERE dep_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`total_amt`) as CREDIT,"receipts" as TABLES FROM receipts  WHERE receipt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`total_amt`) as CREDIT,"personalloan_receipts" as TABLES FROM personalloan_receipts  WHERE receipt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `date` AS DATES,SUM(`bal_amt`) as CREDIT,"replace_loans" as TABLES FROM replace_loans  WHERE date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`add_less`) as CREDIT,"receipts" as TABLES FROM receipts  WHERE receipt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`add_less`) as CREDIT,"personalloan_receipts" as TABLES FROM personalloan_receipts  WHERE receipt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`add_less`) as CREDIT,"replace_payments" as TABLES FROM replace_payments  WHERE pymt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`add_less`) as CREDIT,"deposit_payments" as TABLES FROM deposit_payments  WHERE pymt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`dep_amt`) as CREDIT,"deposit_payments" as TABLES FROM deposit_payments  WHERE pymt_date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('m-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['DEBIT'];
                } else {
                    $data[$md] = $query['DEBIT'];
                }
            }
            $data['results'] = $data;
        } else if ($voucher_id == "Interest Received") {
            $query = '(SELECT `receipt_date` AS DATES,SUM(`rcvd_int_amt`) as AMOUNT,"receipts" as TABLES FROM receipts  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`rcvd_int_amt`) as AMOUNT,"personalloan_receipts" as TABLES FROM personalloan_receipts  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `vch_date` AS DATES,SUM(`credit`) as AMOUNT,"vouchers" as TABLES FROM vouchers WHERE particulars ="48" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('m-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
        } else if ($voucher_id == "Interest Paid") {
            $query = '(SELECT `pymt_date` AS DATES,SUM(`paid_int_amt`) as AMOUNT,"replace_payments" as TABLES FROM replace_payments  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`paid_int_amt`) as AMOUNT,"deposit_payments" as TABLES FROM deposit_payments  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `vch_date` AS DATES,SUM(`debit`) as AMOUNT,"vouchers" as TABLES FROM vouchers   WHERE particulars ="46" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('m-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
        } else if (isset($id)) {
            $get = $this->db->get_where('banks', array('bank_id' => $id, 'status != ' => 'Trash'))->row();
            $query = '(SELECT `date` AS DATES,SUM(`loan_amount`) as AMOUNT,"replace_loans" as TABLES FROM replace_loans  WHERE  bank_name = ' . $id . '  AND date > "2019-03-31" AND status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`loan_amt`) as AMOUNT,"replace_payments" as TABLES FROM replace_payments  WHERE bank_name = "' . $get->bank_name . '" AND pymt_date > "2019-03-31" AND  status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('m-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
        } else {
            $getdetails = $this->db->select('vch_date')->order_by('vch_date', "asc")->group_by('MONTH(vch_date), YEAR(vch_date)')->get_where("vouchers", array('vch_date>' => '2019-03-30', 'particulars' => $voucher_id, 'status !=' => 'Trash'))->result();
            $data['getdetails'] = $getdetails;
            //  $id = $this->input->get('id');
            //   $replaceloan = $this->db->select('date')->order_by('date', "asc")->group_by('MONTH(date), YEAR(date)')->get_where("replace_loans", array('date>'=>'2019-03-30','bank_name' => $id, 'status !=' => 'Trash'))->result();
            //  $data['replaceloan'] = $replaceloan;
        }
        $data['template'] = "admin/view_vch_details";
        $this->load->view('admin/template', $data);
    }

    public function profit_loss_detail() {
        $this->load->model('financemodel', "a");
        //$this->load->view("view_details"); 
        $voucher_id = $this->input->get('voucher_id');
        $getdetails = $this->db->select('vch_date')->order_by('vch_date', "asc")->group_by('MONTH(vch_date), YEAR(vch_date)')->get_where("vouchers", array('particulars' => $voucher_id, 'status !=' => 'Trash'))->result();
        // print_r($getdetails);exit;
        $data['getdetails'] = $getdetails;
        $query = '(SELECT `receipt_date` AS DATES,SUM(`add_less`) as AMOUNT,"receipts" as TABLES FROM receipts WHERE receipt_date > "2019-03-31" AND status!="Trash"  GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`add_less`) as AMOUNT,"personalloan_receipts" as TABLES FROM personalloan_receipts WHERE receipt_date > "2019-03-31" AND status!="Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`add_less`) as AMOUNT,"replace_payments" as TABLES FROM replace_payments WHERE pymt_date > "2019-03-31" AND status!="Trash" GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`add_less`) as AMOUNT,"deposit_payments" as TABLES FROM deposit_payments WHERE pymt_date > "2019-03-31" AND status!="Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
        $query = $this->db->query($query)->result_array();
        $data = array();
        foreach ($query as $query) {
            $md = date('m-Y', strtotime($query['DATES']));
            if (!empty($data[$md])) {
                $data[$md] += $query['AMOUNT'];
            } else {
                $data[$md] = $query['AMOUNT'];
            }
        }
        $data['results'] = $data;
        $commission = $this->db->select('date')->order_by('date', "asc")->group_by('MONTH(date), YEAR(date)')->get_where('replace_loans', array('date>' => '2019-03-31', 'status !=' => 'Trash'))->result();
        $data['commissionres'] = $commission;
        $paidint = $this->db->select('pymt_date')->order_by('pymt_date', "asc")->group_by('MONTH(pymt_date), YEAR(pymt_date)')->get_where('replace_payments', array('status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $q1 = $this->db->select('receipt_date')->select_sum('add_less')->group_by('MONTH(receipt_date), YEAR(receipt_date)')->get_where('receipts', array('status !=' => 'Trash'))->result();
        $data['rec_result'] = $q1;
        $q2 = $this->db->select('pymt_date')->select_sum('add_less')->group_by('MONTH(pymt_date), YEAR(pymt_date)')->order_by('pymt_date', "asc")->get_where('replace_payments', array('status !=' => 'Trash'))->result();
        $data['rep_results'] = $q2;
        $q3 = $this->db->select('receipt_date')->select_sum('add_less')->group_by('MONTH(receipt_date), YEAR(receipt_date)')->order_by('receipt_date', "asc")->get_where('personalloan_receipts', array('status !=' => 'Trash'))->result();
        $data['pl_results'] = $q3;
        $q4 = $this->db->select('pymt_date')->select_sum('add_less')->group_by('MONTH(pymt_date), YEAR(pymt_date)')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('status !=' => 'Trash'))->result();
        $data['dep_results'] = $q4;
        //print_r($q1);exit;
        $addless = array_merge($q1, $q2, $q3, $q4);
        //print_r($addless);exit;
        // $data['addless_results'] = $addless;
        $loanint = $this->db->select('receipt_date')->order_by('receipt_date', "asc")->group_by('MONTH(receipt_date), YEAR(receipt_date)')->get_where('receipts', array('status !=' => 'Trash'))->result();
        $data['loanint'] = $loanint;
        $ploanint = $this->db->select('receipt_date')->order_by('receipt_date', "asc")->group_by('MONTH(receipt_date), YEAR(receipt_date)')->get_where('personalloan_receipts', array('status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $data['template'] = "admin/profit_loss_detail";
        $this->load->view('admin/template', $data);
    }

    public function loans_details() {
        $this->load->model('financemodel', "a");
        $voucher_id = $this->input->get('voucher_id');
        if ($voucher_id == "loans") {
            $query = '(SELECT `loan_date` AS DATES,SUM(`loan_amount`) as AMOUNT,"loans" as TABLES FROM loans  WHERE loan_date > "2019-03-31" AND status != "Trash"  GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`loan_amt`) as AMOUNT,"receipts" as TABLES FROM receipts  WHERE receipt_date > "2019-03-31" AND status != "Trash"  GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('F-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['results'] = $data;
        } else if ($voucher_id == "ploans") {
            $query = '(SELECT `loan_date` AS DATES,SUM(`loan_amount`) as AMOUNT,"personal_loans" as TABLES FROM personal_loans  WHERE status != "Trash"  GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `receipt_date` AS DATES,SUM(`loan_amt`) as AMOUNT,"personalloan_receipts" as TABLES FROM personalloan_receipts   WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('F-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['presults'] = $data;
        } else if ($voucher_id == "deposits") {
            $query = '(SELECT `dep_date` AS DATES,SUM(`dep_amount`) as AMOUNT,"deposits" as TABLES FROM deposits WHERE status != "Trash"  GROUP BY MONTH(DATES),YEAR(DATES)) UNION (SELECT `pymt_date` AS DATES,SUM(`dep_amt`) as AMOUNT,"deposit_payments" as TABLES FROM deposit_payments WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('F-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['dresults'] = $data;
        } else if ($voucher_id == "reploans") {
            $query = '(SELECT `pymt_date` AS DATES,SUM(`loan_amt`) as AMOUNT,"replace_payments" as TABLES FROM replace_payments  WHERE status != "Trash" GROUP BY MONTH(DATES),YEAR(DATES))';
            $query = $this->db->query($query)->result_array();
            $data = array();
            foreach ($query as $query) {
                $md = date('F-Y', strtotime($query['DATES']));
                if (!empty($data[$md])) {
                    $data[$md] += $query['AMOUNT'];
                } else {
                    $data[$md] = $query['AMOUNT'];
                }
            }
            $data['rpesults'] = $data;
        }
        $data['template'] = "admin/loans_details";
        $this->load->view('admin/template', $data);
    }

    public function replace_day_report() {
        $this->load->model('financemodel', "a");

        $name = $this->input->get('name');
        $rep_month = $this->input->get('month');
        $rep_year = $this->input->get('year');

        $get = $this->db->get_where('banks', array('bank_id' => $name, 'status != ' => 'Trash'))->row();
        $bankdetails = $this->db->select('*')->order_by('date', "asc")->get_where("replace_loans", array('bank_name' => $name, 'MONTH(date)' => $rep_month, 'YEAR(date)' => $rep_year, 'status !=' => 'Trash'))->result();
        $data['bankdetails'] = $bankdetails;

        $payments = $this->db->select('*')->order_by('pymt_date', "asc")->get_where("replace_payments", array('bank_name' => $get->bank_name, 'MONTH(pymt_date)' => $rep_month, 'YEAR(pymt_date)' => $rep_year, 'status !=' => 'Trash'))->result();
        $data['pymtdetails'] = $payments;


        $data['template'] = "admin/replace_day_report";
        $this->load->view('admin/template', $data);
    }

    public function loan_day_report() {
        $this->load->model('financemodel', "a");
        $id = $this->input->get('name');
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $get_tot_from_loans = $this->db->select('*')->order_by('loan_date', "asc")->get_where('loans', array('MONTH(loan_date)' => $month, 'YEAR(loan_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_loans'] = $get_tot_from_loans;
        $get_tot_from_ploans = $this->db->select('*')->order_by('loan_date', "asc")->get_where('personal_loans', array('MONTH(loan_date)' => $month, 'YEAR(loan_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_ploans'] = $get_tot_from_ploans;
        $get_tot_from_recpt = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_recpt'] = $get_tot_from_recpt;
        $get_tot_from_precpt = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('personalloan_receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_precpt'] = $get_tot_from_precpt;
        $get_tot_from_deposits = $this->db->select('*')->order_by('dep_date', "asc")->get_where('deposits', array('MONTH(dep_date)' => $month, 'YEAR(dep_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_deposits'] = $get_tot_from_deposits;
        $get_tot_from_deppay = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_deppay'] = $get_tot_from_deppay;
        $get_tot_from_reppay = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('replace_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_reppay'] = $get_tot_from_reppay;
        $data['template'] = "admin/loan_day_report";
        $this->load->view('admin/template', $data);
    }

    public function day_report() {
        $this->load->model('financemodel', "a");
        $id = $this->input->get('name');
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $getdetails = $this->db->select('*')->order_by('vch_date', "asc")->get_where("vouchers", array('particulars' => $id, 'MONTH(vch_date)' => $month, 'YEAR(vch_date)' => $year, 'status !=' => 'Trash'))->result();       // print_r($getdetails);exit;
        $data['getdetails'] = $getdetails;
        //print_r($getdetails);
        $commission = $this->db->select('*')->order_by('date', "asc")->get_where('replace_loans', array('MONTH(date)' => $month, 'YEAR(date)' => $year, 'status !=' => 'Trash'))->result();
        $data['commissionres'] = $commission;
        $paidint = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('replace_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['paidint'] = $paidint;
        $paiddepint = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['paiddepint'] = $paiddepint;
        $loanint = $this->db->select('*')->order_by('receipt_date', "asc")->select_sum('rcvd_int_amt')->group_by('loan_no')->get_where('receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['loanints'] = $loanint;
        $ploanint = $this->db->select('*')->order_by('receipt_date', "asc")->select_sum('rcvd_int_amt')->group_by('loan_no')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['ploanint'] = $ploanint;
        $q1 = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['rec_results'] = $q1;
        $q2 = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('replace_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['repl_results'] = $q2;
        $q3 = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('personalloan_receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['pl_results'] = $q3;
        $q4 = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['dep_results'] = $q4;
        $get_tot_from_loans = $this->db->select('*')->order_by('loan_date', "asc")->get_where('loans', array('MONTH(loan_date)' => $month, 'YEAR(loan_date)' => $year, 'status !=' => 'Trash'))->result();
        // print_r($get_tot_from_loans);exit;
        $data['get_tot_from_loans'] = $get_tot_from_loans;
        $get_tot_from_ploans = $this->db->select('*')->order_by('loan_date', "asc")->get_where('personal_loans', array('MONTH(loan_date)' => $month, 'YEAR(loan_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_ploans'] = $get_tot_from_ploans;
        $get_tot_from_rploans = $this->db->select('*')->order_by('date', "asc")->get_where('replace_loans', array('MONTH(date)' => $month, 'YEAR(date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_rploans'] = $get_tot_from_rploans;
        $get_tot_from_deposits = $this->db->select('*')->order_by('dep_date', "asc")->get_where('deposits', array('MONTH(dep_date)' => $month, 'YEAR(dep_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_deposits'] = $get_tot_from_deposits;
        $get_tot_from_recpt = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_recpt'] = $get_tot_from_recpt;
        $get_tot_from_precpt = $this->db->select('*')->order_by('receipt_date', "asc")->get_where('personalloan_receipts', array('MONTH(receipt_date)' => $month, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_precpt'] = $get_tot_from_precpt;
        $get_tot_from_deppay = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_deppay'] = $get_tot_from_deppay;
        $get_tot_from_reppay = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('replace_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_tot_from_reppay'] = $get_tot_from_reppay;
        $get_ctot_from_voucher = $this->db->select('*')->order_by('vch_date', "asc")->get_where('vouchers', array('MONTH(vch_date)' => $month, 'YEAR(vch_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_ctot_from_voucher'] = $get_ctot_from_voucher;
        $get_dtot_from_voucher = $this->db->select('*')->order_by('vch_date', "asc")->get_where('vouchers', array('MONTH(vch_date)' => $month, 'YEAR(vch_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_dtot_from_voucher'] = $get_dtot_from_voucher;
        $get_inttot_from_deppay = $this->db->select('*')->order_by('pymt_date', "asc")->get_where('deposit_payments', array('MONTH(pymt_date)' => $month, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
        $data['get_inttot_from_deppay'] = $get_inttot_from_deppay;
        //$cash_amt = $get_tot_from_loans[0]->loan_amount + $get_tot_from_ploans[0]->loan_amount + $get_tot_from_rploans[0]->bal_amt + $get_tot_from_deposits[0]->dep_amount + $get_tot_from_recpt[0]->total_amt + $get_tot_from_precpt[0]->total_amt + $get_tot_from_deppay[0]->dep_amt + $get_tot_from_reppay[0]->total_amt + $get_ctot_from_voucher[0]->credit - $get_dtot_from_voucher[0]->debit - $get_inttot_from_deppay[0]->paid_int_amt;
        $data['template'] = "admin/day_report";
        $this->load->view('admin/template', $data);
    }

    public function user_display() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $results = $this->db->order_by("user_id", "desc")->get_where('users', array('status !=' => 'Trash'))->result();
        $data['results'] = $results;
        //$data['doclist'] = $this->sunraymodel->doctor_list();
        $data['template'] = "admin/user_display";
        $this->load->view('admin/template', $data);
    }

    public function user_create() {
        $this->checkadmin();
        $this->load->model('financemodel');
        if (isset($_POST['submit'])) {
            $data = array('user_name' => $_POST['user_name'],
                'user_type' => $_POST['user_type'],
                'password' => $_POST['password'],
                'repeat' => $_POST['repeat'],
                'days' => $_POST['days'],
                'login_reset' => $_POST['login_reset'],
            );
            $this->financemodel->user_create($data);
            $this->session->set_flashdata('success', 'Inserted successfully!');
            redirect('admin/user_display', 'refresh');
        }
        $data['template'] = "admin/user_create";
        $this->load->view('admin/template', $data);
    }

    public function edit_user() {
        $this->checkadmin();
        $this->load->model('financemodel');
        $user_id = $this->input->get('user_id');
        $result = $this->db->get_where("users", array('user_id' => $user_id))->row();
        if (isset($_POST['submit'])) {
            $data = array('user_name' => $_POST['user_name'],
                'user_type' => $_POST['user_type'],
                'password' => $_POST['password'],
                'repeat' => $_POST['repeat'],
                'days' => $_POST['days'],
                'login_reset' => $_POST['login_reset'],
            );
            $this->db->where('user_id', $user_id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('success', 'Updated successfully!');
            redirect("admin/user_display");
        }
        $data['result'] = $result;
        $data['template'] = "admin/edit_user";
        $this->load->view('admin/template', $data);
    }

    public function delete_user($user_id = null) {
        $this->checkadmin();
        $result = $this->db->get_where("users", array('user_id' => $user_id))->row();
        if (!empty($result)) {
            $this->db->where('user_id', $user_id);
            $this->db->update('users', array('status' => 'Trash'));
            $this->session->set_flashdata('success', 'Deleted successfully!');
            redirect('admin/user_display', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Error');
            redirect('admin/user_display', 'refresh');
        }
    }

    public function change_year() {
        $this->checkadmin();
        $data['template'] = "admin/change_year";
        $this->load->view('admin/template', $data);
    }

    public function store_category() {
        $this->load->model('financemodel');
        $results = $this->db->select('under')->get_where('ledger', array('ledger_id' => $_REQUEST['particulars'], 'status != ' => 'Trash'))->row();
        $array['under'] = $results->under;
        $cr_check = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $_REQUEST['particulars'], 'status != ' => 'Trash'))->row();
        $dr_check = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $_REQUEST['particulars'], 'status != ' => 'Trash'))->row();
        if ($cr_check->credit < $dr_check->debit) {
            $array['balance'] = ($dr_check->debit - $cr_check->credit) . "Dr";
        } else {
            $array['balance'] = ($cr_check->credit - $dr_check->debit) . "Cr";
        }
        echo json_encode($array);
    }

    public function check_name() {
        $this->load->model('financemodel');
        $checkparty = $this->db->get_where('parties', array('party_name' => $_REQUEST['name'], 'status != ' => 'Trash'))->row();
        $array['name'] = $checkparty->party_name;
        echo json_encode($array);
    }

    public function check_depparty_name() {
        $this->load->model('financemodel');
        $checkdepparty = $this->db->get_where('deposit_parties', array('party_name' => $_REQUEST['party_name'], 'status != ' => 'Trash'))->row();
        $array['party_name'] = $checkdepparty->party_name;
        echo json_encode($array);
    }

    public function check_bank_name() {
        $this->load->model('financemodel');
        $checkbank = $this->db->get_where('banks', array('bank_name' => $_REQUEST['bank_name'], 'status != ' => 'Trash'))->row();
        $array['bank_name'] = $checkbank->bank_name;
        echo json_encode($array);
    }

    public function check_item_name() {
        $this->load->model('financemodel');
        $checkbank = $this->db->get_where('items', array('item_name' => $_REQUEST['item'], 'status != ' => 'Trash'))->row();
        $array['item_name'] = $checkbank->item_name;
        echo json_encode($array);
    }

    public function check_ledger() {
        $this->load->model('financemodel');
        $checkledger = $this->db->get_where('ledger', array('name' => $_REQUEST['name'], 'status != ' => 'Trash'))->row();
        $array['name'] = $checkledger->name;
        echo json_encode($array);
    }

    public function check_category() {
        $this->load->model('financemodel');
        $checkcategory = $this->db->get_where('ledger_categories', array('name' => $_REQUEST['name'], 'status != ' => 'Trash'))->row();
        $array['name'] = $checkcategory->name;
        echo json_encode($array);
    }

    public function check_loanno() {
        $this->load->model('financemodel');
        $check_loanno = $this->db->get_where('loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
        $array['loan_no'] = $check_loanno->loan_no;
        echo json_encode($array);
    }

    public function check_bankloanno() {
        $this->load->model('financemodel');
        $check_bankloanno = $this->db->get_where('replace_loans', array('bank_loan_no' => $_REQUEST['bank_loan_no'], 'status != ' => 'Trash'))->row();
        $array['bank_loan_no'] = $check_bankloanno->bank_loan_no;
        echo json_encode($array);
    }

    public function check_ploanno() {
        $this->load->model('financemodel');
        $check_ploanno = $this->db->get_where('personal_loans', array('loan_no' => $_REQUEST['loan_no'], 'status != ' => 'Trash'))->row();
        $array['loan_no'] = $check_ploanno->loan_no;
        echo json_encode($array);
    }

    public function check_depno() {
        $this->load->model('financemodel');
        $check_depno = $this->db->get_where('deposits', array('dep_no' => $_REQUEST['dep_no'], 'status != ' => 'Trash'))->row();
        $array['dep_no'] = $check_depno->dep_no;
        echo json_encode($array);
    }
    public function find_prev_date() {
        $this->load->model('financemodel');
        $date=$_REQUEST['receipt_date'];
        $res=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $array['int_rcvd_upto_dt'] = $res;
        echo json_encode($array);
    }
    public function find_pymt_prev_date() {
        $this->load->model('financemodel');
        $date=$_REQUEST['pymt_date'];
        $res=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $array['int_paid_upto_date'] = $res;
        echo json_encode($array);
    }

}
