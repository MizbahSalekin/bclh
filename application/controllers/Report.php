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
        $this->global['pageTitle'] = 'Gavi : Dashboard';

        $this->loadViews("general/dashboard", $this->global, NULL, NULL);
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

            $this->global['pageTitle'] = 'Gavi : E-Screening';
            $data['report_title'] = 'E-Screening Checklist';

            $this->loadViews("reports/e_screening", $this->global, $data, NULL);
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

            $this->global['pageTitle'] = 'Gavi : E-Supervision';
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

            $this->global['pageTitle'] = 'Gavi : E-Screening';

            $this->loadViews("reports/e_screening", $this->global, $data, NULL);
        }
    }

}

?>