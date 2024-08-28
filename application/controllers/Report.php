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

    function eScreening()
    {
        if ($this->isAdmin()) {
            $this->loadThis();
        } else {
            // Capture search filters
            $division_id = $this->input->post('division_id');
            $district_id = $this->input->post('district_id');
            $upazila_id = $this->input->post('upazila_id');
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $division  = $this->report_model->getDivision();
            $district  = $this->report_model->getDistrict();
            $upaz  = $this->report_model->getUpazilla();

            $result_data = '';
            $this->load->library('pagination');
            if($this->input->server('REQUEST_METHOD') === 'POST'){
                $result_data = $this->report_model->eScreening_model();
            }

            $data['result_data'] = $result_data;
            $data['division'] = $division;
            $data['district'] = $district;
            $data['upaz'] = $upaz;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            $this->global['pageTitle'] = 'BCLH : E-Screening';
            $data['report_title'] = 'E-Screening Checklist';
            $data['report_sub_title'] = 'E-Screening Checklist: Summarized View';

            $this->loadViews("reports/e_screening", $this->global, $data, NULL);
        }
    }

    function eScreening_summary()
    {
        if ($this->isAdmin()) {
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
            $data['report_sub_title'] = 'E-Screening Checklist: Detailed View';

            $this->loadViews("reports/e_screening_summary", $this->global, $data, NULL);
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

    public function get_union_by_upazilaid() {
    $upazilaid = $this->input->post('upazilaid');  // Get the upazilaid value from the POST data
    
    if ($upazilaid) {
        // Load the database library if it's not autoloaded
        $this->load->database();

        // Query the unions table for the matching upazilaid
        $this->db->select('unionid, unionnameeng');
        $this->db->from('unions');
        $this->db->where('upazilaid', $upazilaid);
        $query = $this->db->get();
        
        // Return the results as JSON
        $result = $query->result_array();
        echo json_encode($result);
    } else {
        echo json_encode([]);  // Return an empty array if upazilaid is not provided
    }
}

    function eSupervision()
    {
        if ($this->isAdmin()) {
            $this->loadThis();
    } else {
        // Capture search filters
        $upazila_id = $this->input->post('upazila_id');
        $union_id = $this->input->post('union_id');
        $searchText = '';
        if (!empty($this->input->post('searchText'))) {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
        }
            $data['searchText'] = $searchText;

            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $upaz  = $this->report_model->getUpazilla();
            $uni  = $this->report_model->getUnion();

            // pre($upaz); die();

            $this->load->library('pagination');
            $result_data = '';

            if($this->input->server('REQUEST_METHOD') === 'POST'){
             $result_data = $this->report_model->eSupervision_model();
            }

            $data['result_data'] = $result_data;
            $data['upaz'] = $upaz;
            $data['uni'] = $uni;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            $this->global['pageTitle'] = 'BCLH : E-Supervision';
            $data['report_title'] = 'E-Supervision Checklist';
            $data['report_sub_title'] = 'E-Supervision Checklist: Summarized View';

            $this->loadViews("reports/e_supervision", $this->global, $data, NULL);

    }
}

    function eSupervision_summary()
    {
        if ($this->isAdmin()) {
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



            // $this->load->library('pagination');

            $result_data = $this->report_model->eSupervision_summary_model();

            $data['result_data'] = $result_data;
            $data['division'] = $division;
            $data['district'] = $district;
            $data['upaz'] = $upaz;

            $this->global['pageTitle'] = 'BCLH : E-Supervision Summary';
            $data['report_title'] = 'E-Supervision Checklist Summary';
            $data['report_sub_title'] = 'E-Supervision Checklist: Detailed View';

            $this->loadViews("reports/e_supervision_summary", $this->global, $data, NULL);
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