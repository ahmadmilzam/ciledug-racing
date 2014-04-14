<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    /**
     * Constructor
     *
     * @return void
     */
    function __construct($config = array())
    {
        // Merged super-global $_FILES to $_POST to allow for better file validation inside of Form_validation library
        $_POST = (isset($_FILES) && is_array($_FILES) && count($_FILES) > 0) ? array_merge($_POST,$_FILES) : $_POST;

        parent::__construct($config);

    }//end __construct()

    /**
     * Form validation run Hack
     * to make it work proprly with HMVC
     */
    function run($module = '', $group = '') {
        (is_object($module)) AND $this->CI =& $module;
        return parent::run($group);
    }

    /**
     * Returns Form Validation Errors in a HTML Un-ordered list format.
     *
     * @access public
     *
     * @return string Returns Form Validation Errors in a HTML Un-ordered list format.
     */
    public function validation_errors_list()
    {
        if (is_array($this->CI->form_validation->_error_array))
        {
            $errors = (array) $this->CI->form_validation->_error_array;
            $error  = '<ul class="alert-list">' . PHP_EOL;

            foreach ($errors as $err)
            {
                $error .= " <li>{$err}</li>" . PHP_EOL;
            }

            $error .= '</ul>' . PHP_EOL;
            return $error;
        }

        return FALSE;

    }//end validation_errors_list()

    /**
     * Check that a string only contains Alpha-numeric characters with
     * periods, underscores, spaces and dashes
     *
     * @abstract Alpha-numeric with periods, underscores, spaces and dashes
     * @access public
     *
     * @param string $str The string value to check
     *
     * @return  bool
     */
    function alpha_extra($str)
    {
        $this->CI->form_validation->set_message('alpha_extra', 'The %s field may only contain alpha-numeric characters, spaces, periods, underscores, and dashes.');
        return ( ! preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;

    }//end alpha_extra()

    /**
     * @abstract Ensures a string is a valid URL
     * @access public
     *
     * @param string $str The string value to check
     *
     * @return  bool
     */
    function valid_url($url) {
        if(preg_match("/^http(|s):\/{2}(.*)\.([a-z]){2,}(|\/)(.*)$/i", $url)) {
            if(filter_var($url, FILTER_VALIDATE_URL)) return TRUE;
        }
        $this->CI->form_validation->set_message('valid_url', 'The %s must be a valid URL.');
        return FALSE;
    }//end valid_url()

    /**
     * @abstract Numeric and commas characters
     * @access public
     *
     * @param string $str The string value to check
     *
     * @return  bool
     */
    function numeric_comma($str) {
        $this->CI->form_validation->set_message('numeric_comma', 'The %s may only contain numeric & comma characters.');
        return ( ! preg_match("/^(\d+,)*\d+$/", $str)) ? FALSE : TRUE;
    }//end numeric_comma()

    /**
     * Check that the string matches a specific regex pattern
     *
     * @access public
     *
     * @param string $str     The string to check
     * @param string $pattern The pattern used to check the string
     *
     * @return bool
     */
    function matches_pattern($str, $pattern)
    {
        if (preg_match('/^' . $pattern . '$/', $str))
        {
            return TRUE;
        }

        $this->CI->form_validation->set_message('matches_pattern', 'The %s field does not match the required pattern.');

        return FALSE;

    }//end matches_pattern()

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
