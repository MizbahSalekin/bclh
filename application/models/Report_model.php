<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model
{
    function getDivision(){

        $query = "SELECT DISTINCT divisioneng FROM division where upload = 1 ORDER BY divisioneng ASC";

        $division = $this->db->query($query);
        return $division->result();
    }

    function getDistrict(){

        $query = "SELECT DISTINCT zillanameeng FROM zilla where upload = 1 ORDER BY zillanameeng ASC";

        $district = $this->db->query($query);
        return $district->result();
    }

    function getUpazilla(){

        $query = "SELECT DISTINCT upazilanameeng FROM upazila where upload = 1 ORDER BY upazilanameeng ASC";

        $upaz = $this->db->query($query);
        return $upaz->result();
    }

     public function get_report_data($start_date, $end_date) {
        // Build the query
        $this->db->select('*');
        $this->db->from('section_1_screening_checklist_idf');
        $this->db->where('uploaddt >=', $start_date);
        $this->db->where('uploaddt <=', $end_date);

        // Execute the query and return results
        $query = $this->db->get();
        return $query->result_array();
    }

    function eScreening_summary_model()
        {
        $queryRadio = "SELECT
                        SUM(CASE 
                            WHEN s1.q109 LIKE '%test%' 
                            OR s2.q201 LIKE '%test%' 
                            OR s2.q206a LIKE '%test%' 
                            OR s2.q206b LIKE '%test%'
                            THEN 1 
                            ELSE 0
                        END) AS Test_Child,
                        SUM(CASE
                        WHEN s2.q205b = 2 
                            AND s2.q203 = 2 
                            AND (s1.q109 NOT LIKE '%test%' 
                            OR s2.q201 NOT LIKE '%test%' 
                            OR s2.q206a NOT LIKE '%test%' 
                            OR s2.q206b NOT LIKE '%test%') 
                            THEN 1 
                            ELSE 0
                        END) AS Zero_Dose_Count,
                        SUM(CASE
                            WHEN s2.q203 = 2
                            AND s2.q205b = 1
                            AND 
                            (s2.q205c = 2
                            AND s2.q205d = 2) 
                            AND
                            (s1.q109 NOT LIKE '%test%'
                                OR s2.q201 NOT LIKE '%test%'
                                OR s2.q206a NOT LIKE '%test%'
                                OR s2.q206b NOT LIKE '%test%'
                            ) 
                            THEN 1 
                            ELSE 0
                        END) AS Under_Immunized_Count,
                        SUM(CASE
                              WHEN s2.q203 = 1
                              OR (s2.q205b = 1
                              AND s2.q205c = 1
                              AND s2.q205d = 1
                            )
                            AND
                            (s1.q109 NOT LIKE '%test%'
                                OR s2.q201 NOT LIKE '%test%'
                                OR s2.q206a NOT LIKE '%test%'
                                OR s2.q206b NOT LIKE '%test%'
                            )
                              THEN 1
                              ELSE 0
                            END
                          ) AS Drop_Out_Count,
                        COUNT(DISTINCT s1.idno) AS Total_Screening_Count,
                        SUM(IF((s2.q212 = 1) OR (s2.q212 = 2) , 1, 0) ) AS Vaccinated
                        FROM
                        section_1_screening_checklist_idf s1 
                        JOIN section_2_vaccinations_info s2 
                        ON s2.idno = s1.idno
                        LEFT JOIN providerdb p 
                            ON p.providerid = CAST(s1.entryuser AS INTEGER) 
                        LEFT JOIN providertype pt 
                            ON pt.provtype = CAST(s1.q107 AS INTEGER) 
                        LEFT JOIN zilla z 
                            ON z.zillaid = s1.zillaid 
                        LEFT JOIN upazila u 
                            ON u.zillaid = s1.zillaid 
                            AND u.upazilaid = s1.upazilaid 
                        LEFT JOIN unions un 
                            ON un.zillaid = s1.zillaid 
                            AND un.upazilaid = s1.upazilaid 
                            AND un.unionid = s1.unionid 
                        LEFT JOIN cluster c 
                            ON c.clusterid = CAST(s2.q211 AS INTEGER) 
                        WHERE s2.idno IS NOT NULL";

        $radio_query_result = $this->db->query($queryRadio);
        return $radio_query_result->result();
    }

    function eSupervision_summary_model()
    {
        $queryRadio = "SELECT 
                        z.zillanameeng,
                        u.upazilanameeng,
                        un.unionnameeng,
                        p.provname,
                        c.ward_no,
                        c.epi_sub_block,
                        c.epi_cluster_name,
                        s1.interviewer_date,
                        s1.q105,
                        s1.q106,
                        s1.q107,
                        pt.typename,
                        s2.idno,
                        s1.slno,
                        s2.q111,
                        s2.q111a,
                        s2.q111b,
                        s2.q111c,
                        s2.q111d,
                        s2.q111e,
                        s2.q111x,
                        s2.q111x1,
                        s2.q112a,
                        s2.q112a1,
                        s2.q112a2,
                        s2.q112b,
                        s2.q112b1,
                        s2.q112b2,
                        s2.q112c,
                        s2.q112c1,
                        s2.q112c2,
                        s2.q112d,
                        s2.q112d1,
                        s2.q112d2,
                        s2.q112e,
                        s2.q112e1,
                        s2.q112e2,
                        s2.q112f,
                        s2.q112f1,
                        s2.q112f2,
                        s2.q112g,
                        s2.q112g1,
                        s2.q112g2,
                        s2.q112h,
                        s2.q112h1,
                        s2.q112h2,
                        s2.q112i,
                        s2.q112i1,
                        s2.q112i2,
                        s2.q112j,
                        s2.q112j1,
                        s2.q112j2,
                        s2.q112k,
                        s2.q112k1,
                        s2.q112k2,
                        s2.q112l,
                        s2.q112l1,
                        s2.q112l2,
                        s2.q113,
                        s2.q112p1a,
                        s2.q112p1b,
                        s2.q112p1c,
                        s2.q112p1d,
                        s2.q112p1e,
                        s2.q112p1x,
                        s2.q112p1x1,
                        s2.q112p2a,
                        s2.q112p2b,
                        s2.q112p2c,
                        s2.q112p2d,
                        s2.q112p2e,
                        s2.q112p2x,
                        s2.q112p2x1,
                        s2.q112p3a,
                        s2.q112p3b,
                        s2.q112p3c,
                        s2.q112p3d,
                        s2.q112p3e,
                        s2.q112p3x,
                        s2.q112p3x1,
                        s2.q112m1a,
                        s2.q112m1b,
                        s2.q112m1c,
                        s2.q112m1d,
                        s2.q112m1e,
                        s2.q112m1x,
                        s2.q112m1x1,
                        s1.uploaddt 
                        FROM
                        section_1_identifications_ipc_reg s1 
                        JOIN section_1_manager_staff_service s2 
                            ON s2.idno = s1.idno 
                        LEFT JOIN providerdb p 
                            ON p.providerid = CAST(s1.entryuser AS UNSIGNED) 
                        LEFT JOIN providertype pt 
                            ON pt.provtype = CAST(s1.q107 AS UNSIGNED) 
                        LEFT JOIN zilla z 
                            ON z.zillaid = s1.zillaid 
                        LEFT JOIN upazila u 
                            ON u.zillaid = s1.zillaid 
                            AND u.upazilaid = s1.upazilaid 
                        LEFT JOIN unions un 
                            ON un.zillaid = s1.zillaid 
                            AND un.upazilaid = s1.upazilaid 
                            AND un.unionid = s1.unionid 
                        LEFT JOIN cluster c 
                            ON c.clusterid = CAST(s1.q106 AS UNSIGNED) 
                        WHERE s2.idno IS NOT NULL ;
                    ";

        $radio_query_result = $this->db->query($queryRadio);
        return $radio_query_result->result();
    }

    function eScreening_model()
    {
        $queryRadio = "SELECT 
                        s1.zillaid,
                        z.zillanameeng,
                        z.zillaname,
                        s1.upazilaid,
                        u.upazilanameeng,
                        u.upazilaname,
                        s1.unionid,
                        un.unionnameeng,
                        un.unionname,
                        s1.entryuser,
                        p.provname,
                        c.ward_no,
                        c.epi_sub_block,
                        c.clusterid,
                        c.epi_cluster_name,
                        s2.idno,
                        s1.slno,
                        s1.q105,
                        s1.q106,
                        s1.q107,
                        pt.typename,
                        s1.q108,
                        s1.q109,
                        s2.q201,
                        s2.q202,
                        s2.q202a,
                        s2.q202b1,
                        s2.q202b2,
                        s2.q202b3,
                        s2.q203,
                        s2.q204a,
                        s2.q204b,
                        s2.q204c,
                        s2.q204d,
                        s2.q204e,
                        s2.q204f,
                        s2.q204g,
                        s2.q204h,
                        s2.q204i,
                        s2.q204j,
                        s2.q204k,
                        s2.q204l,
                        s2.q204x,
                        s2.q204x1,
                        s2.q205a,
                        s2.q205b,
                        s2.q205c,
                        s2.q205d,
                        s2.q205e,
                        s2.q205f,
                        s2.q205x,
                        s2.q206a,
                        s2.q206b,
                        s2.q206c,
                        s2.q206d,
                        s2.q207,
                        s2.q208,
                        s2.q209,
                        s2.q210,
                        s2.q211,
                        s2.q212,
                        s2.q212a,
                        s2.q212b,
                        s2.q212c,
                        s2.q212d,
                        s2.q212e,
                        s2.q212f,
                        s2.q212g,
                        s2.q212h,
                        s2.q212x,
                        s2.q212x1,
                        s2.q213,
                        s1.uploaddt 
                        FROM
                        section_1_screening_checklist_idf s1 
                        JOIN section_2_vaccinations_info s2 
                            ON s2.idno = s1.idno 
                        LEFT JOIN providerdb p 
                            ON p.providerid = CAST(s1.entryuser AS INTEGER) 
                        LEFT JOIN providertype pt 
                            ON pt.provtype = CAST(s1.q107 AS INTEGER) 
                        LEFT JOIN zilla z 
                            ON z.zillaid = s1.zillaid 
                        LEFT JOIN upazila u 
                            ON u.zillaid = s1.zillaid 
                            AND u.upazilaid = s1.upazilaid 
                        LEFT JOIN unions un 
                            ON un.zillaid = s1.zillaid 
                            AND un.upazilaid = s1.upazilaid 
                            AND un.unionid = s1.unionid 
                        LEFT JOIN cluster c 
                            ON c.clusterid = CAST(s2.q211 AS INTEGER) 
                        WHERE s2.idno IS NOT NULL ;
                    ";

        $radio_query_result = $this->db->query($queryRadio);
        return $radio_query_result->result();
    }

    function eSupervision_model()
    {
        $queryRadio = "SELECT 
                        s1.zillaid,
                        z.zillanameeng,
                        z.zillaname,
                        s1.upazilaid,
                        u.upazilanameeng,
                        u.upazilaname,
                        s1.unionid,
                        un.unionnameeng,
                        un.unionname,
                        s1.entryuser,
                        p.provname,
                        c.ward_no,
                        c.epi_sub_block,
                        c.clusterid,
                        c.epi_cluster_name,
                        s1.interviewer_id,
                        s1.interviewer_date,
                        s1.q105,
                        s1.q106,
                        s1.q107,
                        pt.typename,
                        s2.idno,
                        s1.slno,
                        s2.q111,
                        s2.q111a,
                        s2.q111b,
                        s2.q111c,
                        s2.q111d,
                        s2.q111e,
                        s2.q111x,
                        s2.q111x1,
                        s2.q112a,
                        s2.q112a1,
                        s2.q112a2,
                        s2.q112b,
                        s2.q112b1,
                        s2.q112b2,
                        s2.q112c,
                        s2.q112c1,
                        s2.q112c2,
                        s2.q112d,
                        s2.q112d1,
                        s2.q112d2,
                        s2.q112e,
                        s2.q112e1,
                        s2.q112e2,
                        s2.q112f,
                        s2.q112f1,
                        s2.q112f2,
                        s2.q112g,
                        s2.q112g1,
                        s2.q112g2,
                        s2.q112h,
                        s2.q112h1,
                        s2.q112h2,
                        s2.q112i,
                        s2.q112i1,
                        s2.q112i2,
                        s2.q112j,
                        s2.q112j1,
                        s2.q112j2,
                        s2.q112k,
                        s2.q112k1,
                        s2.q112k2,
                        s2.q112l,
                        s2.q112l1,
                        s2.q112l2,
                        s2.q113,
                        s2.q112p1a,
                        s2.q112p1b,
                        s2.q112p1c,
                        s2.q112p1d,
                        s2.q112p1e,
                        s2.q112p1x,
                        s2.q112p1x1,
                        s2.q112p2a,
                        s2.q112p2b,
                        s2.q112p2c,
                        s2.q112p2d,
                        s2.q112p2e,
                        s2.q112p2x,
                        s2.q112p2x1,
                        s2.q112p3a,
                        s2.q112p3b,
                        s2.q112p3c,
                        s2.q112p3d,
                        s2.q112p3e,
                        s2.q112p3x,
                        s2.q112p3x1,
                        s2.q112m1a,
                        s2.q112m1b,
                        s2.q112m1c,
                        s2.q112m1d,
                        s2.q112m1e,
                        s2.q112m1x,
                        s2.q112m1x1,
                        s1.uploaddt 
                        FROM
                        section_1_identifications_ipc_reg s1 
                        JOIN section_1_manager_staff_service s2 
                            ON s2.idno = s1.idno 
                        LEFT JOIN providerdb p 
                            ON p.providerid = CAST(s1.entryuser AS UNSIGNED) 
                        LEFT JOIN providertype pt 
                            ON pt.provtype = CAST(s1.q107 AS UNSIGNED) 
                        LEFT JOIN zilla z 
                            ON z.zillaid = s1.zillaid 
                        LEFT JOIN upazila u 
                            ON u.zillaid = s1.zillaid 
                            AND u.upazilaid = s1.upazilaid 
                        LEFT JOIN unions un 
                            ON un.zillaid = s1.zillaid 
                            AND un.upazilaid = s1.upazilaid 
                            AND un.unionid = s1.unionid 
                        LEFT JOIN cluster c 
                            ON c.clusterid = CAST(s1.q106 AS UNSIGNED) 
                        WHERE s2.idno IS NOT NULL ;
                    ";

        $radio_query_result = $this->db->query($queryRadio);
        return $radio_query_result->result();
    }

    function userListingCount($searchText)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.createdDtm, 
        Role.role, Role.status as roleStatus');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role, status as roleStatus');
        $this->db->from('tbl_roles');
        $query = $this->db->get();

        return $query->result();
    }

}