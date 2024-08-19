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

    public function get_upazila_by_zillaid() {
    $zillaid = $this->input->post('zillaid');  // Get the zillaid value from the POST data
    
    if ($zillaid) {
        // Load the database library if it's not autoloaded
        $this->load->database();

        // Query the upazila table for the matching zillaid
        $this->db->select('upazilaid, upazilanameeng');
        $this->db->from('upazila');
        $this->db->where('zillaid', $zillaid);
        $query = $this->db->get();
        
        // Return the results as JSON
        $result = $query->result_array();
        echo json_encode($result);
    } else {
        echo json_encode([]);  // Return an empty array if zillaid is not provided
    }
}



    public function generate_report() {
    // Get the start and end dates from the form
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
            $district  = $this->report_model->getDistrict();
            $upaz  = $this->report_model->getUpazilla();
    $zilla_id = $this->input->post('zilla_id'); // Add this line to get the zilla filter
    $upazila_id = $this->input->post('upazila_id'); // Add this line to get the upazila filter

    // Validate that the start date is not later than the end date
    if (strtotime($start_date) > strtotime($end_date)) {
        $data['error'] = "Start date cannot be later than end date.";
        $this->load->view('report_form', $data);
    } else {
        // Fetch data from the model with the remaining filters
        $data['results'] = $this->report_model->get_report_data($start_date, $end_date, $zilla_id, $upazila_id);
        $data['district'] = $district;
        $data['upaz'] = $upaz;
        $this->global['pageTitle'] = 'BCLH : E-Supervision';
        $data['report_title'] = 'E-Supervision Report';

        // Load the view to display the results
        $this->loadViews("reports/e_s", $this->global, $data, NULL);
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

    // public function total_screening_count() {
    //     // Assuming you have a model that fetches the count
    //     $this->load->model('report_model');
    //     $data['total_screening_count'] = $this->report_model->get_total_screening_count();

    //     // Load your view and pass the data
    //     $this->load->view('general/dashboard', $data);
    // }

}

?>