<div class="content-wrapper">
    <!-- Page header -->                
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Master</a></li>
                <li><a href="item_display">Item</a></li>
                <li class="active">Add Item</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <!-- Horizontal form options -->                    <!-- /fieldset legend -->                    <!-- 2 columns form -->                    
        <form class="form-horizontal form-validation" id="formID" action="#" method="post" autocomplete="off">
            <div class="panel panel-flat  loan-panel">
                <div class="panel-body">
                    <fieldset>
                        <legend>
                            <div class="button-style-2 invoice-button back-btn">
                                <a href="item_display"><span class="trans-icons-3"></span>Back</a>     
                            </div>
                        </legend>
                        <div class="trans-table">
                            <div class="trans-table-head"><h4>Add Item</h4></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Item Name<span>:</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="item_name" id="item" placeholder="Enter Item Name" class="form-control validate[required]" style="display: block;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Group Name<span>:</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control validate[required] input-height" name="group_name">
                                                <option value="">Select Item Group..</option>  
                                                <?php
                                                foreach ($itemresults as $result) {
                                                    ?>
                                                    <option value="<?php echo $result->item_group; ?>"><?php echo $result->item_group; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-buttons-wrapper">     
                                <div class="span12">                
                                    <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Submit </button>     
                                </div>                               
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <!-- /2 columns form -->                    <!-- Footer -->                    
    </div>
    <!-- /main content -->     
</div>
<script>
    jQuery(document).ready(function () {
        jQuery("#formID").validationEngine();
    });
</script>
<script>
    $('#item').change(function () {
        $.ajax({
            url: "<?php echo base_url('admin/check_item_name') ?>",
            data: 'item=' + $(this).val(),
            dataType: "json",
            success: function (data) {
                if (data.item_name != '') {
                    alert("Item Name already exist !");
                }
            }
        });
    });
</script>