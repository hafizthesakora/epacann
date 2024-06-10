<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class financemodel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add_party($data) {
        $this->db->insert('parties', $data);
        return true;
    }
    public function test($data) {
        $this->db->insert('loans', $data);
        return true;
    }
     public function settings($data) {
        $this->db->insert('settings', $data);
        return true;
    }
     public function partyadd($data) {
        $this->db->insert('parties', $data);
        return true;
    }

    public function create_loan($data) {
        $this->db->insert('loans', $data);
        return true;
    }
     public function loan_data($data) {
        $this->db->insert('group_table', $data);
        return true;
    }
      public function ploan_data($data) {
        $this->db->insert('group_table', $data);
        return true;
    }
     public function loan_receipt_data($data) {
        $this->db->insert('group_table', $data);
        return true;
    }
     public function rplloan_data($data) {
        $this->db->insert('group_table', $data);
        return true;
    }

    public function create_receipt($data) {
        $this->db->insert('receipts', $data);
        return true;
    }

    public function ploan_receipt_create($data) {
        $this->db->insert('personalloan_receipts', $data);
        return true;
    }

    public function replace_loan_create($data) {
        $this->db->insert('replace_loans', $data);
        return true;
    }
    public function rplloan($data) {
        $this->db->insert('replaceloans_additional', $data);
        return true;
    }

    public function deposit_pymt_create($data) {
        $this->db->insert('deposit_payments', $data);
        return true;
    }

    public function area_create($data) {
        $this->db->insert('areas', $data);
        return true;
    }
 public function add_bankname($data) {
        $this->db->insert('banks', $data);
        return true;
    }
    public function item_create($data) {
        $this->db->insert('items', $data);
        return true;
    }

    public function itemgroup_create($data) {
        $this->db->insert('item_groups', $data);
        return true;
    }

    public function add_dep_party($data) {
        $this->db->insert('deposit_parties', $data);
        return true;
    }

    public function reference_create($data) {
        $this->db->insert('references', $data);
        return true;
    }

    public function ledger_create($data) {
        $this->db->insert('ledger', $data);
        return true;
    }

    public function profile($data) {
        $this->db->insert('admin', $data);
        return true;
    }

    public function create_ledger_grp($data) {
        $this->db->insert('ledger_group', $data);
        return true;
    } public function add_ledgercategory($data) {
        $this->db->insert('ledger_categories', $data);
        return true;
    }   

   
    public function ploan_create($data) {
        $this->db->insert('personal_loans', $data);
        return true;
    }

    public function create_deposit($data) {
        $this->db->insert('deposits', $data);
        return true;
    }

    public function replace_pymt_create($data) {
        $this->db->insert('replace_payments', $data);
        return true;
    }
    public function voucher_create($data) {
        $this->db->insert('vouchers', $data);
        return true;
    }
 public function daybook_display($data) {
        $this->db->insert('daybooks', $data);
        return true;
    }
    public function user_create($data) {
        $this->db->insert('users', $data);
        return true;
    }
    public function fetchtable() 
        {  
            $query = $this->db->query('select year(loan_date) as year, month(loan_date) as month, sum(loan_amount) as total_amount from loans group by year(loan_date), month(loan_date)');   

            return $query->result();  
        }   
}
