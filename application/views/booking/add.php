<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Patient Management
        <small>Add / Edit Patient</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Patient Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addBooking" action="<?php echo base_url() ?>booking/addNewBooking" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="zil_Name">Zilla</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('zil_Name'); ?>" id="zil_Name" name="zil_Name" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="upz_Name">Upazilla</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('upz_Name'); ?>" id="upz_Name" name="upz_Name" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="uni_Name">Union</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('uni_Name'); ?>" id="uni_Name" name="uni_Name" maxlength="256" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="war_Name">Ward No.</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('war_Name'); ?>" id="war_Name" name="war_Name" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="sc_Type">Service Center Type</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('sc_Type'); ?>" id="sc_Type" name="sc_Type" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="sp_d">Service Provider Designation</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('sp_d'); ?>" id="sp_d" name="sp_d" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="int_dt">Interview Date</label>
                                        <input type="date" class="form-control required" value="<?php echo set_value('int_dt'); ?>" id="int_dt" name="int_dt" maxlength="256" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="pName">Child Name</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('pName'); ?>" id="pName" name="pName" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="fName">Father Name</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('fName'); ?>" id="fName" name="fName" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="mName">Mother Name</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('mName'); ?>" id="mName" name="mName" maxlength="256" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" class="form-control" value="<?php echo set_value('description'); ?>" id="description" name="description" maxlength="256" /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>