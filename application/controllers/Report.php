<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Report extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'BCLH : Dashboard';

        $this->loadViews("general/dashboard", $this->global, NULL, NULL);
    }

    function eScreening_summary()
    {
        if (!$this->isAdmin()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $result_data = $this->report_model->eScreening_summary_model();

            $data['result_data'] = $result_data;

            $this->global['pageTitle'] = 'BCLH : E-Screening Summary';
            $data['report_title'] = 'E-Screening Checklist Summary';

            $this->loadViews("reports/e_screening_summary", $this->global, $data, NULL);
        }
    }

    function eScreening()
    {
        if (!$this->isAdmin()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $result_data = $this->report_model->eScreening_model();

            $data['result_data'] = $result_data;

            $this->global['pageTitle'] = 'BCLH : E-Screening';
            $data['report_title'] = 'E-Screening Checklist';

            $this->loadViews("reports/e_screening", $this->global, $data, NULL);
        }
    }

    function eSupervision_summary()
    {
        if (!$this->isAdmin()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $division  = $this->report_model->getDivision();
            // pre($division[0]->zillanameeng);
            // die();

            $district  = $this->report_model->getDistrict();
            $upaz  = $this->report_model->getUpazilla();



            $this->load->library('pagination');

            $result_data = $this->report_model->eSupervision_summary_model();

            $data['result_data'] = $result_data;
            $data['division'] = $division;
            $data['district'] = $district;
            $data['upaz'] = $upaz;

            $this->global['pageTitle'] = 'BCLH : E-Supervision Summary';
            $data['report_title'] = 'E-Supervision Checklist Summary';

            $this->loadViews("reports/e_supervision_summary", $this->global, $data, NULL);
        }
    }

    public function generate_report() {
        // Get the start and end dates from the form
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        // Validate that the start date is not later than the end date
        if (strtotime($start_date) > strtotime($end_date)) {
            $data['error'] = "Start date cannot be later than end date.";
            $this->load->view('report_form', $data);
        } else {
            // Fetch data from the model
            $data['results'] = $this->report_model->get_report_data($start_date, $end_date);
            $this->global['pageTitle'] = 'BCLH : E-Supervision';
            $data['report_title'] = 'E-Supervision Report';
            $this->loadViews("reports/e_s", $this->global, $data, NULL);
            // $this->load->view('report_results', $data);  // Load the view to display the results
        }
    }

    function eSupervision()
    {
        if (!$this->isAdmin()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $result_data = $this->report_model->eSupervision_model();

            $data['result_data'] = $result_data;

            $this->global['pageTitle'] = 'BCLH : E-Supervision';
            $data['report_title'] = 'E-Supervision Checklist';

            $this->loadViews("reports/e_supervision", $this->global, $data, NULL);
        }
    }

    function userListing()
    {
        if (!$this->isAdmin()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->report_model->userListingCount($searchText);

            $returns = $this->paginationCompress("userListing/", $count, 10);

            $data['userRecords'] = $this->report_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'BCLH : E-Screening';

            $this->loadViews("reports/e_screening", $this->global, $data, NULL);
        }
    }

}

?>