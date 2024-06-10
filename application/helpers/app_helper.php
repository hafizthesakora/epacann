<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('test_method')) {

    function test_method($var = '') {
        return $var;
    }

}


function moneyformat($num = NULL) {
    $sign = ($num < 0) ? "-" : "";
    $num = abs($num);

    $explrestunits = "";
    $num = preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des = "00";
    if (count($words) <= 2) {
        $num = $words[0];
        if (count($words) >= 2) {
            $des = $words[1];
        }
        if (strlen($des) < 2) {
            $des = "$des";
        } else {
            $des = substr($des, 0, 2);
        }
    }
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
// creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    //  $thecash = $sign * $thecash;
    return $sign . "$thecash.$des"; // writes the final format where $currency is the currency symbol.
}

function daybook_balance($fromdate = NULL) {
    $this->load->model('financemodel');
    $this->daybook_display();
    if (!empty($results)) {
        foreach ($results as $res) {
            $cb = $debit = $credit = 0;
            $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->loan_amount;
            $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->loan_amount;
            $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->loan_amt;
            $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->rcvd_int_amt;
            $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->loan_amt;
            $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->rcvd_int_amt;
            $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->dep_amount;
            $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->dep_amt;
            $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->paid_int_amt;
            $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->loan_amt;
            $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->paid_int_amt;
            $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->loan_amount;
            $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->other_amt;
            $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
            $debit += $resultq->debit;
            $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
            $credit += $resultq->credit;
            $cb = $credit - $debit;
        }
        return "$cb";
//          /  print_r($cb);exit;
    }
}

?>