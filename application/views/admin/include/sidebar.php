<?php
$check = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row();
$docid = $this->session->userdata('admin_id');
?>
<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <li>
                        <a href="#" class="media-left"><img src="<?php echo base_url(); ?>uploads/<?php echo $check->profile; ?>" class="img-circle img-sm" alt=""><span class="admin">Admin</span></a>
                        <ul>
                            <li class="<?php echo show_current_class('profile'); ?>"><a href="profile" id="layout2">Edit Profile</a></li>
                             <!--<li class="disabled"><a href="../../layout_5/LTR/index.html" id="layout5">Layout 5 <span class="label">Coming soon</span></a></li>-->
                        </ul>
                    </li>
                    <li class="maintab">
                        <a href="#"><i class="icon-user"></i> <span>Entry</span></a>
                        <ul>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'create_loan') || ($this->uri->segment('2') == 'edit_loan') || ($this->uri->segment('2') == 'view_loan')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('loan_display'); ?>"><a href="loan_display"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                    Loans</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'create_receipt') || ($this->uri->segment('2') == 'edit_receipt') || ($this->uri->segment('2') == 'view_receipt')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('receipt_display'); ?>"><a href="receipt_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Receipt</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'replace_loan_create') || ($this->uri->segment('2') == 'edit_rep_loan') || ($this->uri->segment('2') == 'view_rep_loan')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('replace_loan_display'); ?>"><a href="replace_loan_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Replace Loan</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'replace_pymt_create')|| ($this->uri->segment('2') == 'edit_rep_pymt') || ($this->uri->segment('2') == 'view_rep_pymt')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('replace_pymt_display'); ?>"><a href="replace_pymt_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Replace Payment</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'ploan_create') || ($this->uri->segment('2') == 'edit_ploan') || ($this->uri->segment('2') == 'view_ploan')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('ploan_display'); ?>"><a href="ploan_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Personal Loan</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'ploan_receipt_create')|| ($this->uri->segment('2') == 'edit_plreceipt') || ($this->uri->segment('2') == 'view_plreceipt')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('ploan_receipt_display'); ?>"><a href="ploan_receipt_display"><i class="fa fa-angle-right" aria-hidden="true"></i>PLoan Receipt</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'create_deposit') || ($this->uri->segment('2') == 'edit_deposit') || ($this->uri->segment('2') == 'view_deposit')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('deposit_display'); ?>"><a href="deposit_display"><i class="fa fa-angle-right" aria-hidden="true"></i>SUSU</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'deposit_pymt_create')|| ($this->uri->segment('2') == 'edit_dep_pymt') || ($this->uri->segment('2') == 'view_dep_pymt')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('deposit_pymt_display'); ?>"><a href="deposit_pymt_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Dep Payment</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'voucher_create')|| ($this->uri->segment('2') == 'edit_voucher') || ($this->uri->segment('2') == 'view_voucher')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <!-- <li class="<?php echo $class; ?><?php echo show_current_class('voucher_display'); ?>"><a href="voucher_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Voucher</a></li> -->
                        </ul>
                    </li>
                    <li class="maintab">
                        <a href="#"><i class="fa fa-files-o" aria-hidden="true"></i>
                            <span>Master</span></a>
                        <ul>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'add_party') || ($this->uri->segment('2') == 'edit_party') || ($this->uri->segment('2') == 'view_party')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('party_display'); ?>"><a href="party_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Party Name</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'add_dep_party') || ($this->uri->segment('2') == 'edit_dep_party') || ($this->uri->segment('2') == 'view_dep_party')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('dep_party_display'); ?>"><a href="dep_party_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Dep Party Name</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'area_create') || ($this->uri->segment('2') == 'edit_area') || ($this->uri->segment('2') == 'view_area')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('area_display'); ?>"><a href="area_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Area</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'add_bankname') || ($this->uri->segment('2') == 'edit_bank') || ($this->uri->segment('2') == 'view_bank')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('bank_display'); ?>"><a href="bank_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Bank Name</a></li>
                                <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'item_create') || ($this->uri->segment('2') == 'edit_item') || ($this->uri->segment('2') == 'view_item')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('item_display'); ?>"><a href="item_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Item</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'itemgroup_create') || ($this->uri->segment('2') == 'edit_itemgroup') || ($this->uri->segment('2') == 'view_itemgroup')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('itemgroup_display'); ?>"><a href="itemgroup_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Item Group</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'reference_create') || ($this->uri->segment('2') == 'edit_reference') || ($this->uri->segment('2') == 'view_reference')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('reference_display'); ?>"><a href="reference_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Reference</a></li>
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'ledger_create') || ($this->uri->segment('2') == 'edit_ledger') || ($this->uri->segment('2') == 'view_ledger')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('ledger_display'); ?>"><a href="ledger_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Ledger</a></li>
                            <?php
                           // if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'create_ledger_grp') || ($this->uri->segment('2') == 'edit_ledgergrp') || ($this->uri->segment('2') == 'view_ledgergrp')) {
                          //      $class = "active";
                           // } else {
                           //     $class = "";
                           // }
                            ?>
                            <!--<li class="<?php echo $class; ?><?php echo show_current_class('ledger_grp_display'); ?>"><a href="ledger_grp_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Ledger Group</a></li>-->
                            <?php
                            if (($this->uri->segment('1') == 'admin') && ($this->uri->segment('2') == 'add_ledger_category') || ($this->uri->segment('2') == 'edit_ledgercategory') || ($this->uri->segment('2') == 'view_ledgercategory')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?><?php echo show_current_class('ledger_category'); ?>"><a href="ledger_category"><i class="fa fa-angle-right" aria-hidden="true"></i>Ledger Category</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="icon-chart"></i> <span>Report</span></a>
                        <ul>
                            <li class=""><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i>Pending</a>
                                <ul class="sublist">
                                    <?php
                                    if (($this->uri->segment('2') == 'loan_pending')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?> 
                                    <li class="<?php echo $class; ?>"><a href="loan_pending" style=" padding-left: 87px !important;">Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'replace_pending')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>    
                                    <li class="<?php echo $class; ?>"><a href="replace_pending" style=" padding-left: 87px !important;">Replace Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'ploan_pending')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>  
                                    <li class="<?php echo $class; ?>"><a href="ploan_pending" style=" padding-left: 87px !important;">Personal Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'deposit_pending')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?> 
                                    <li class="<?php echo $class; ?>"><a href="deposit_pending" style=" padding-left: 87px !important;">SUSU</a></li>
                                </ul>
                            </li>
                            <li class=""><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i>A/c Closed List</a>
                                <ul class="sublist">
                                    <?php
                                    if (($this->uri->segment('2') == 'ac_closed_list')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>
                                    <li class="<?php echo $class; ?>"><a href="ac_closed_list" style=" padding-left: 87px !important;">Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'replace_closed_list')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>
                                    <li class="<?php echo $class; ?>"><a href="replace_closed_list" style=" padding-left: 87px !important;">Replace Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'ploan_closed_list')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>
                                    <li class="<?php echo $class; ?>"><a href="ploan_closed_list" style=" padding-left: 87px !important;">Personal Loan</a></li>
                                    <?php
                                    if (($this->uri->segment('2') == 'deposit_closed_list')) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    ?>
                                    <li class="<?php echo $class; ?>"><a href="deposit_closed_list" style=" padding-left: 87px !important;">SUSU</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php
                            if (($this->uri->segment('2') == 'view_details' || $this->uri->segment('2') == 'view_vch_details' || $this->uri->segment('2') == 'profit_loss_detail' || $this->uri->segment('2') == 'day_report')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
         <!--           <li class="maintab <?php echo $class; ?>">
                        <a href="#"><i class="icon-user"></i> <span>Accounts</span></a>
                        <ul>
                            <?php
                            if (($this->uri->segment('2') == 'daybook_display' || $this->uri->segment('2') == 'daybook_date_filter')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="daybook_display"><i class="fa fa-angle-right" aria-hidden="true"></i>Day Book</a></li>
                           <?php
                            if (($this->uri->segment('2') == 'trialbalance' || $this->uri->segment('2') == 'trialbalance_search')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="trialbalance"><i class="fa fa-angle-right" aria-hidden="true"></i>Trial Balance</a></li>
                            <?php
                            if (($this->uri->segment('2') == 'balance_sheet' || $this->uri->segment('2') == 'balance_sheet_search')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="balance_sheet"><i class="fa fa-angle-right" aria-hidden="true"></i>Balance Sheet</a></li>
                            <?php
                            if (($this->uri->segment('2') == 'profit_loss' || $this->uri->segment('2') == 'profit_loss_detail' || $this->uri->segment('2') == 'profloss_search')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="profit_loss"><i class="fa fa-angle-right" aria-hidden="true"></i>Profit And Loss</a></li>
                             <?php
                            if (($this->uri->segment('2') == 'ledger_voucher' || $this->uri->segment('2') == 'ledger_voucher_display')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                            <li class="<?php echo $class; ?>"><a href="ledger_voucher"><i class="fa fa-angle-right" aria-hidden="true"></i>Ledger</a></li>
                        </ul>
                    </li> -->
                    <!-- <li class="maintab">
                        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i>
                            <span>Features</span></a>
                        <ul>
                            <li class="<?php echo show_current_class('inv_setup'); ?>"><a href="inv_setup"><i class="fa fa-angle-right" aria-hidden="true"></i>Inv Setup</a></li>
                            <li class="<?php echo show_current_class('general_setup'); ?>"><a href="general_setup"><i class="fa fa-angle-right" aria-hidden="true"></i>Gen Setup</a></li>
                            <li class="<?php echo show_current_class('user_display'); ?>"><a href="user_display"><i class="fa fa-angle-right" aria-hidden="true"></i>User</a></li>
                            <li class="<?php echo show_current_class(''); ?>">
                                <a href="loan_pending"><i class="fa fa-angle-right" aria-hidden="true"></i>Financial Year</a>
                                <ul class="sublist">
                                      <?php
                            if (($this->uri->segment('2') == 'change_year')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>
                                     <li class="<?php echo $class; ?>"><a href="change_year" style=" padding-left: 87px !important;">Change Year</a></li>
                                     <?php
                            if (($this->uri->segment('2') == 'split_data')) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>    
                                     <li class="<?php echo $class; ?>"><a href="" style=" padding-left: 87px !important;">Split Data</a></li>
                                     
                                  </ul>
                            </li>
                            <li class="<?php echo show_current_class(''); ?>"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i>Reorganize</a></li>
                        </ul>
                    </li> -->
<!--                    <li>
                        <a href="#"><i class="icon-server"></i> <span>Company</span></a>
                        <ul>
                            <li><a href="wizard_steps.html">Select</a></li>
                            <li><a href="wizard_steps.html">Create</a></li>
                            <li><a href="wizard_steps.html">Alter</a></li>
                            <li><a href="wizard_steps.html">Backup</a></li>
                            <li><a href="wizard_steps.html">Restore</a></li>
                            <li><a href="wizard_steps.html">AttachDb</a></li>
                            <li><a href="wizard_steps.html">Server Name</a></li>
                        </ul>
                    </li>-->
                    <li>
                        <a href="<?php echo base_url('admin/logout'); ?>"><i class="icon-share"></i> <span>Quit</span></a>
                    </li>
                    <!-- /page kits -->
                </ul>
            </div>
        </div>
        <!-- /main navigation -->
    </div>
</div>