<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_page extends MY_Model {

    public function get_redaksi()
    {
        $this->db->where('status', 'aktif');
        $this->db->get('table_redaksi');

        $result = $this->db->result();

        return $result;
    }

    public function get_page_tree()
    {
        $all_pages = $this->db
            ->select('id, parent_id, title, status')
            ->order_by('`order`')
            ->get('pages')
            ->result_array();

        // First, re-index the array.
        foreach ($all_pages as $row)
        {
            $pages[$row['id']] = $row;
        }

        unset($all_pages);

        // Build a multidimensional array of parent > children.
        foreach ($pages as $row)
        {
            if (array_key_exists($row['parent_id'], $pages))
            {
                // Add this page to the children array of the parent page.
                $pages[$row['parent_id']]['children'][] =& $pages[$row['id']];
            }

            // This is a root page.
            if ($row['parent_id'] == 0)
            {
                $page_array[] =& $pages[$row['id']];
            }
        }

        return $page_array;
    }

}

/* End of file model_page.php */
/* Location: ./application/modules/page/models/model_page.php */