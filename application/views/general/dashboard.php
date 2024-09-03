<head>
  <style>
      html, body {
          height: 100%;
          margin: 0;
          padding: 0;
      }
      body {
          background: url('<?php echo base_url(); ?>assets/dist/img/BCLH_Map.png') no-repeat center center fixed;
          background-size: cover;
          overflow: auto;
      }
      .content-wrapper {
          position: relative;
          z-index: 1; /* Ensure content is above the background */
          padding: auto;
          background: #Ffffff; /* Optional: slightly opaque background to improve readability */
      }
      .logo_icddrb {
          width: 100%;
          height: auto;
          max-width: 100%; /* Ensure the image does not exceed the viewport width */
      }
  </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-tachometer" aria-hidden="true"></i> Real-Time Information Dashboard
                <small>Control panel</small>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>397<sup style="font-size: 20px"></sup></h3>
                            <h2>E-Screening Checklist</h2>
                            <p>Status of Identified <strong>Zero Dose, Under Immunized</strong> & <strong>Drop Out</strong> Children</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>eScreening_summary" class="small-box-footer">For Summarized View: Click Here...<i class="fa fa-arrow-circle-right"></i></a>
                        <a href="<?php echo base_url(); ?>eScreening" class="small-box-footer">For Detailed View: Click Here...<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                
                </div><!-- ./col -->
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>163</h3>
                            <h2>E-Supervision Checklist</h2>
                            <p>Status of Expanded Programme on Immunization (EPI) Supervisor's Field Visit</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>eSupervision_summary" class="small-box-footer">For Summarized View: Click Here...<i class="fa fa-arrow-circle-right"></i></a>
                        <a href="<?php echo base_url(); ?>eSupervision" class="small-box-footer">For Detailed View: Click Here...<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <img src="<?php echo base_url(); ?>assets/dist/img/BCLH_Map.png" class="logo_icddrb" alt="logo_icddrb" />
                    <!-- <h3>Modules <span style="color:red"> "Booking" </span> & <span style="color:red"> "Tasks" </span> created to demonstrate Roles Access.</h3> -->
                </div>
            </div>
        </section>
    </div>
</body>
