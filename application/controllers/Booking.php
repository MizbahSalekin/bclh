<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Booking (BookingController)
 * Booking Class to control booking related operations.
 * @author : uhc@icddrb.org
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Booking extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model', 'bm');
        $this->isLoggedIn();
        $this->module = 'Booking';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('booking/bookingListing');
    }

    /**
     * This function is used to load the booking list
     */
    function bookingListing()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->bm->bookingListingCount($searchText);

            $returns = $this->paginationCompress("bookingListing/", $count, 10);

            $data['records'] = $this->bm->bookingListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Gavi : Booking';

            $this->loadViews("booking/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Gavi : Add New Booking';

            $this->loadViews("booking/add", $this->global, NULL, NULL);
        }
    }

    public function validate_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

  /**
     * This function is used to add new Patient to the system
     */
    function addNewBooking()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('zil_Name', 'Zilla', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('upz_Name', 'Upazilla', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('uni_Name', 'Union', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('war_Name', 'Ward', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('sc_Type', 'Service Center Type', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('sp_d', 'Service Provider Designation', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('int_dt','Interview Date','trim|required|callback_validate_date');
            // $this->form_validation->set_rules('int_dt','Interview Date','trim|required|valid_date');
            $this->form_validation->set_rules('pName', 'Child Name', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('fName', 'Father Name', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('mName', 'Mother Name', 'trim|callback_html_clean|required|max_length[50]');            
            $this->form_validation->set_rules('description', 'Description', 'trim|callback_html_clean|required|max_length[1024]');

            if ($this->form_validation->run() == FALSE) {
                $this->add();
            } else {
                $zil_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('zil_Name'))));
                $upz_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('upz_Name'))));
                $uni_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('uni_Name'))));
                $war_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('war_Name'))));
                $sc_Type = ucwords(strtolower($this->security->xss_clean($this->input->post('sc_Type'))));
                $sp_d = ucwords(strtolower($this->security->xss_clean($this->input->post('sp_d'))));
                $int_dt = $this->security->xss_clean($this->input->post('int_dt'));
                $pName = ucwords(strtolower($this->security->xss_clean($this->input->post('pName'))));
                $fName = ucwords(strtolower($this->security->xss_clean($this->input->post('fName'))));
                $mName = ucwords(strtolower($this->security->xss_clean($this->input->post('mName'))));
                $description = $this->security->xss_clean($this->input->post('description'));

                $bookingInfo = array(
                    'zil_Name' => $zil_Name,
                    'upz_Name' => $upz_Name,
                    'uni_Name' => $uni_Name,
                    'war_Name' => $war_Name,
                    'sc_Type' => $sc_Type,
                    'sp_d' => $sp_d,
                    'int_dt' => $int_dt,
                    'pName' => $pName,
                    'fName' => $fName,
                    'mName' => $mName,
                    'description' => $description,
                    'createdBy' => $this->vendorId,
                    'createdDtm' => date('Y-m-d H:i:s'));

                $result = $this->bm->addNewBooking($bookingInfo);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Patient created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Patient creation failed');
                }

                redirect('booking/bookingListing');
            }
        }
    }


    /**
     * This function is used load booking edit information
     * @param number $pId : Optional : This is booking id
     */
    function edit($pId = NULL)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            if ($pId == null) {
                redirect('booking/bookingListing');
            }

            $data['bookingInfo'] = $this->bm->getBookingInfo($pId);

            $this->global['pageTitle'] = 'Gavi : Edit Booking';

            $this->loadViews("booking/edit", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editBooking()
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $pId = $this->input->post('pId');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('zil_Name', 'Zilla', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('upz_Name', 'Upazilla', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('uni_Name', 'Union', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('war_Name', 'Ward', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('sc_Type', 'Service Center Type', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('sp_d', 'Service Provider Designation', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('int_dt','Interview Date','trim|required|valid_date');
            $this->form_validation->set_rules('pName', 'Child Name', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('fName', 'Father Name', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('mName', 'Mother Name', 'trim|callback_html_clean|required|max_length[50]');  
            $this->form_validation->set_rules('description', 'Description', 'trim|callback_html_clean|max_length[1024]');

            if ($this->form_validation->run() == FALSE) {
                $this->edit($pId);
            } else {
                $zil_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('zil_Name'))));
                $upz_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('upz_Name'))));
                $uni_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('uni_Name'))));
                $war_Name = ucwords(strtolower($this->security->xss_clean($this->input->post('war_Name'))));
                $sc_Type = ucwords(strtolower($this->security->xss_clean($this->input->post('sc_Type'))));
                $sp_d = ucwords(strtolower($this->security->xss_clean($this->input->post('sp_d'))));
                $int_dt = ucwords(strtolower($this->security->xss_clean($this->input->post('int_dt'))));
                $pName = $this->security->xss_clean($this->input->post('pName'));
                $fName = ucwords(strtolower($this->security->xss_clean($this->input->post('fName'))));
                $mName = ucwords(strtolower($this->security->xss_clean($this->input->post('mName'))));
                $description = $this->security->xss_clean($this->input->post('description'));

                $bookingInfo = array(
                    'zil_Name' => $zil_Name,
                    'upz_Name' => $upz_Name,
                    'uni_Name' => $uni_Name,
                    'war_Name' => $war_Name,
                    'sc_Type' => $sc_Type,
                    'sp_d' => $sp_d,
                    'int_dt' => date('Y-m-d H:i:s'),
                    'pName' => $pName,
                    'fName' => $fName,
                    'mName' => $mName,
                    'description' => $description,
                    'createdBy' => $this->vendorId,
                    'createdDtm' => date('Y-m-d H:i:s'));

                $result = $this->bm->editBooking($bookingInfo, $pId);

                if ($result == true) {
                    $this->session->set_flashdata('success', 'Booking updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Booking updation failed');
                }

                redirect('booking/bookingListing');
            }
        }
    }

    public function html_clean($s, $v)
    {
        return strip_tags((string) $s);
    }
}

?>