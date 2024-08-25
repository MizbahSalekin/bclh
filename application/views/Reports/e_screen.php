<style type="text/css">
td,
th {
    padding: 0;
    text-align: center;
    font-size: 12px;
}

th {
    min-width: 114px;
}

.ms-choice {
    border: none;
    height: 0;
}

.ms-drop {
    left: 0;
}

.table-bordered>thead>tr>th,
.table-bordered>tbody>tr>th,
.table-bordered>tfoot>tr>th,
.table-bordered>thead>tr>td,
.table-bordered>tbody>tr>td,
.table-bordered>tfoot>tr>td {
    border: 1px solid #ccc !important;
}

.dataTables_wrapper {
    overflow-x: scroll;
}
</style>
<script>
//$.noConflict();
$(function() {
    $('#division').multipleSelect({
        placeholder: 'Select Divisions',
        selectAll: true,
        maxHeightUnit: 6,
        minimumCountSelected: 10
    });
    $('#district').multipleSelect({
        placeholder: 'Select District',
        selectAll: true,
        maxHeightUnit: 6,
        minimumCountSelected: 10
    });
    $('#upazilla').multipleSelect({
        placeholder: 'Select Upazilla',
        selectAll: true,
        maxHeightUnit: 6,
        minimumCountSelected: 10
    });
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                    <?php echo $report_title; ?>
                    <?php
                    $CI =& get_instance();
                    ?>
                </h3>
            </div>

        </div>
    </section>

    <section class="content content-margin">

        <div class="row">
            <div class="col-xs-12">

                <?php if (isset($error)): ?>
                        <p style="color:red;"><?php echo $error; ?></p>
                        <?php endif; ?>
                    
                <form id="generate_screening_report" method="post" action="<?= base_url('report/generate_screening_report') ?>">
                    
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">                                
                            <div class="form-group">
                                <label>DISTRICT:</label>
                                    <select name="zilla_id" id="zilla_id">
                                          <option value="0" selected>Select District</option>

                                          <?php foreach($district as $obj){ ?>
                                            <option value="<?php echo $obj->zillaid?>" ><?php echo $obj->zillanameeng?></option>
                                          <?php } ?>
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-4">                                
                            <div class="form-group">
                                <label>UPAZILLA:</label>
                                <select name="upazilla" id="upazilla">
                                    <option value="0" selected>Select Upazilla</option>
                                    <!-- Options will be populated here via AJAX -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

<!-- <h4>Select Date Range for Report</h4> -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">                                
                            <div class="form-group">
                                <label for="date">From Date</label>
                                <input type="date" class="form-control required" id="start_date" name="start_date" value="">
                            </div>
                        </div>
                        <div class="col-md-4">                                
                            <div class="form-group">
                                <label for="date">To Date</label>
                                <input type="date" class="form-control required" id="end_date" name="end_date" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <body>
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" id="filter_submit" class="btn btn-primary" value="Submit" />
                                    <input type="reset" id="filter_reset" class="btn btn-default" value="Reset" onclick="this.form.reset(); window.location.reload();" />
                                </div>
                            </div>
                        </div>

                    </form>
                </body>

                <div class="box box-primary">
                    <div class="box-header">


                        <?php
                        $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if ($error) {
                            ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                        <?php } ?>
                        <?php
                        $success = $this->session->flashdata('success');
                        if ($success) {
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
                    </div><!-- /.box-header -->
                    <div class="box-body parent-sticky">
                        <?php
                        $i = 1;
                        $header = $row_column = '';
                        $division = $district = $thana = 0;
                        foreach ($result_data as $object) {
                            $row_column .= '<tr>';
                            //$arr_geo = array('Present_Division', 'Present_District');
                            foreach ($object as $key => $value) {
                                if ($i == 1)
                                    $header .= '<th>' . str_replace('_', ' ', $key) . '</th>';
                                // $header .= '<th style="width: 1000px;">' . str_replace('_', ' ', $key) . '</th>';
                        
                                if ($key == 'Present_Division' || $key == 'Permanent_Division') {
                                    $row_column .= ($value != 0) ? '<td>' . get_division_name($value) . '</td>' : '<td></td>';
                                    $division = $value;
                                } else if ($key == 'Present_District' || $key == 'Permanent_District') {
                                    $row_column .= ($value != 0) ? '<td style="width: 1000px;">' . get_district_name($division, $value) . '</td>' : '<td></td>';
                                    $district = $value;
                                } else if ($key == 'Present_Upazilla' || $key == 'Permanent_Upazilla') {
                                    $row_column .= ($value != 0) ? '<td>' . get_thana_name($division, $district, $value) . '</td>' : '<td></td>';
                                    $thana = $value;
                                } else if ($key == 'Present_Union' || $key == 'Permanent_Union') {
                                    $row_column .= ($value != 0) ? '<td>' . get_union_name($division, $district, $thana, $value) . '</td>' : '<td></td>';
                                } else if (
                                    ($key == 'radiology_comment_one' && $value != '') || ($key == 'radiology_comment_two' && $value != '') ||
                                    ($key == 'radiology_comment_three' && $value != '') || ($key == 'radiology_comment_four' && $value != '')
                                ) {
                                    $row_column .= '<td style="min-width: 500px; text-align: left;">' . $value . '</td>';
                                } else
                                    $row_column .= '<td>' . $value . '</td>';
                            }
                            $row_column .= '</tr>';
                            $i++;
                        }
                        ?>

                        <h4>Export Data</h4>
                        <table id="example" class="table table-bordered sticky-table" style="width:100%">
                            <thead>
                                <tr>
                                    <?php echo $header; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $row_column; ?>
                            </tbody>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
</div>


<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="box-body" id="modal_box" style="text-align:center">
                    <img id="modal_image" src="" width="450px">
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>


        </div>
    </div>


    <?php


    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src='https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/multiple-select/1.5.2/multiple-select.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#zilla_id').on('change', function() {
                var zillaid = $(this).val(); 
                if (zillaid) {
                    // console.log(zillaid);
                    $.ajax({
                        url: '<?php echo base_url("Report/get_upazila_by_zillaid"); ?>',  
                        type: 'POST',
                        data: { zillaid: zillaid }, 
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);  // Log the response to see what is being returned
                            
                            var upazillaDropdown = $('#upazilla');
                            upazillaDropdown.empty();
                            upazillaDropdown.append('<option value="0" selected>Select Upazila</option>');
                            
                            $.each(response, function(index, upazila) {
                                upazillaDropdown.append('<option value="' + upazila.upazilaid + '">' + upazila.upazilanameeng + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);  // Log any error to the console
                            alert('Error retrieving data.');
                        }
                    });
                } else {
                    $('#upazilla').empty().append('<option value="0" selected>Select Upazila</option>');
                }
            });
        });


    </script>

    <?php if (empty($_POST)) { ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#division').multipleSelect('setSelects', [50]);
        set_district();
    });
    </script>
    <?php } ?>
    <script>
    $(function() {
        $("#filter_submit").click(function() {
            if ($("#start_date").val() == '' || $("#end_date").val() == '') {
                alert("Please input From date and To date.");
                return false;
            }
            $("#generate_report").submit();
        });

        $("input[name='selectAlldivision[]'], input[name='selectItemdivision[]']").on('change', function() {
            set_district();
        });
        <?php if (!empty($_POST)) { ?>
        <?php if (!empty($this->input->post('division'))) { ?>
        $('#division').multipleSelect('setSelects', <?php echo json_encode($this->input->post('division')); ?>);
        set_district();
        <?php } ?>
        <?php if (!empty($this->input->post('district'))) { ?>
        $('#district').multipleSelect('setSelects', <?php echo json_encode($this->input->post('district')); ?>);
        select_district2();
        <?php } ?>
        <?php if (!empty($this->input->post('upazilla'))) { ?>
        $('#upazilla').multipleSelect('setSelects', <?php echo json_encode($this->input->post('upazilla')); ?>);
        select_upazilla2();
        <?php } ?>
        <?php } ?>
    });

    function set_district() {
        division_code = $("#division").multipleSelect("getSelects", 'value');
        length = $("#division").multipleSelect("getSelects").length;
        var options = '';
        if (length > 0) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>report/get_custom_geocode_parameter_data",
                data: {
                    type: 'division',
                    division_code: division_code
                },
                async: false,
                datatype: 'json',
                success: function(response) {
                    var data = jQuery.parseJSON(response);
                    //console.log(data);
                    $.each(data, function(key, obj) {
                        options += '<option value="' + obj.district_code + '">' + obj.district +
                            '</option>';
                    });
                }
            });
        }

        $("#district").html(options);
        $('#district').multipleSelect({
            placeholder: 'Select District',
            selectAll: true,
            maxHeightUnit: 6,
            minimumCountSelected: 10
        });

        select_district();
    }

    function select_district() {
        $("input[name='selectAlldistrict[]'], input[name='selectItemdistrict[]']").on('change', function() {
            select_district2();
        });
    }

    function select_district2() {
        division_code = $("#division").multipleSelect("getSelects", 'value');
        district_code = $("#district").multipleSelect("getSelects", 'value');
        length = $("#district").multipleSelect("getSelects").length;
        var options = '';
        if (length > 0) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>report/get_custom_geocode_parameter_data",
                data: {
                    type: 'district',
                    division_code: division_code,
                    district_code: district_code
                },
                async: false,
                datatype: 'json',
                success: function(response) {
                    var data = jQuery.parseJSON(response);
                    //console.log(data);
                    $.each(data, function(key, obj) {
                        options += '<option value="' + obj.upazilla_code + '">' + obj.upazilla +
                            '</option>';
                    });
                }
            });
        }
        $("#upazilla").html(options);
        $('#upazilla').multipleSelect({
            placeholder: 'Select Upazilla',
            selectAll: true,
            maxHeightUnit: 6,
            minimumCountSelected: 10
        });
        select_upazilla();
    }

    function select_upazilla() {
        $("input[name='selectAllupazilla[]'], input[name='selectItemupazilla[]']").on('change', function() {
            select_upazilla2();
        });
    }

    function select_upazilla2() {
        division_code = $("#division").multipleSelect("getSelects", 'value');
        district_code = $("#district").multipleSelect("getSelects", 'value');
        upazilla_code = $("#upazilla").multipleSelect("getSelects", 'value');
        length = $("#upazilla").multipleSelect("getSelects").length;
        var options = '';
        if (length > 0) {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>report/get_custom_geocode_parameter_data",
                data: {
                    type: 'upazilla',
                    division_code: division_code,
                    district_code: district_code,
                    upazilla_code: upazilla_code
                },
                async: false,
                datatype: 'json',
                success: function(response) {
                    var data = jQuery.parseJSON(response);
                    //console.log(data);
                    $.each(data, function(key, obj) {
                        options += '<option value="' + obj.short_code + '">' + obj.name +
                            '</option>';
                    });
                }
            });
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'csv', 'copy'
            ]
        });
    });
    </script>