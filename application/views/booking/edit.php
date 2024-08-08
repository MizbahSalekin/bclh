<?php
$pId = $bookingInfo->pId;
$zil_Name = $bookingInfo->zil_Name;
$upz_Name = $bookingInfo->upz_Name;
$uni_Name = $bookingInfo->uni_Name;
$war_Name = $bookingInfo->war_Name;
$sc_Type = $bookingInfo->sc_Type;
$sp_d = $bookingInfo->sp_d;
$int_dt = $bookingInfo->int_dt;
$pName = $bookingInfo->pName;
$fName = $bookingInfo->fName;
$mName = $bookingInfo->mName;
$description = $bookingInfo->description;
?>

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
                    
                    <form role="form" action="<?php echo base_url() ?>booking/editBooking" method="post" id="editBooking" role="form">
                        <div class="box-body">
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="zil_Name">Zilla</label>
                                        <input type="text" class="form-control required" value="<?php echo $zil_Name; ?>" id="zil_Name" name="zil_Name" maxlength="256" />
                                        <input type="hidden" value="<?php echo $zil_Name; ?>" name="zil_Name" id="zil_Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="upz_Name">Upazilla</label>
                                        <input type="text" class="form-control required" value="<?php echo $upz_Name; ?>" id="upz_Name" name="upz_Name" maxlength="256" />
                                        <input type="hidden" value="<?php echo $upz_Name; ?>" name="upz_Name" id="upz_Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="uni_Name">Union</label>
                                        <input type="text" class="form-control required" value="<?php echo $uni_Name; ?>" id="uni_Name" name="uni_Name" maxlength="256" />
                                        <input type="hidden" value="<?php echo $uni_Name; ?>" name="uni_Name" id="uni_Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="war_Name">Ward No.</label>
                                        <input type="text" class="form-control required" value="<?php echo $war_Name; ?>" id="war_Name" name="war_Name" maxlength="256" />
                                        <input type="hidden" value="<?php echo $war_Name; ?>" name="war_Name" id="war_Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sc_Type">Service Center Type</label>
                                        <input type="text" class="form-control required" value="<?php echo $sc_Type; ?>" id="sc_Type" name="sc_Type" maxlength="256" />
                                        <input type="hidden" value="<?php echo $sc_Type; ?>" name="sc_Type" id="sc_Type" />
                                    </div>
                                </div>

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="sp_d">Service Provider Designation<</label>
                                        <input type="text" class="form-control required" value="<?php echo $sp_d; ?>" id="sp_d" name="sp_d" maxlength="256" />
                                        <input type="hidden" value="<?php echo $sp_d; ?>" name="sp_d" id="sp_d" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="int_dt">Interview Date</label>
                                        <input type="date" class="form-control required" value="<?php echo $int_dt; ?>" id="int_dt" name="int_dt" maxlength="256" />
                                        <input type="hidden" value="<?php echo $int_dt; ?>" name="int_dt" id="int_dt" />
                                    </div>
                                </div>

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="pName">Child Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $pName; ?>" id="pName" name="pName" maxlength="256" />
                                        <input type="hidden" value="<?php echo $pId; ?>" name="pName" id="pName" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fName">Father Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $fName; ?>" id="fName" name="pName" maxlength="256" />
                                        <input type="hidden" value="<?php echo $fName; ?>" name="fName" id="fName" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="mName">Mother Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $mName; ?>" id="mName" name="mName" maxlength="256" />
                                        <input type="hidden" value="<?php echo $mName; ?>" name="mName" id="mName" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
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