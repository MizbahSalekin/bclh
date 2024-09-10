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
          z-index: 5; 
          padding: 20px; 
          background: rgba(255, 255, 255, 100); 
        }
        .logo_icddrb-wrapper {
          display: flex; 
          justify-content: center; 
          align-items: center; 
          height: 100%; 
          width: 100%; 
        }
        .logo_icddrb {
          max-width: 100%;
          height: auto;
        }

        .small-box .inner {
        text-align: default;
        }

        /* Center align the h3 element */
        .inner h3 {
          text-align: right;
        }

        /* Center align the h3 element */
        .inner h1 {
          text-align: center;
        }

  </style>
</head>

<body>
    <div class="content-wrapper">
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
                            <h2>E-Screening Checklist</h2>
                            <p>Identified <strong>Zero-dose </strong> and <strong>Under-immunized</strong> Children: </p>
                            <h1><strong>363</strong></h1>
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
                            <h2>E-Supervision Checklist</h2>
                            <p>Use of E-Supervision Checklist: </p>
                            <h3>166</h3>
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
                    <div class="logo_icddrb-wrapper">
                        <img src="<?php echo base_url(); ?>assets/dist/img/BCLH_Map.png" class="logo_icddrb" alt="logo_icddrb" />
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
