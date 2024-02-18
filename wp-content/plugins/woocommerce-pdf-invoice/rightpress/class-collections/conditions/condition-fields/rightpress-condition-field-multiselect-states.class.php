<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Load dependencies
require_once 'rightpress-condition-field-multiselect.class.php';

/**
 * Condition Field: Multiselect - States
 *
 * @class RightPress_Condition_Field_Multiselect_States
 * @package RightPress
 * @author RightPress
 */
abstract class RightPress_Condition_Field_Multiselect_States extends RightPress_Condition_Field_Multiselect
{

    protected $key = 'states';

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        parent::__construct();

        $this->hook();
    }

    /**
     * Load multiselect options
     *
     * @access public
     * @param array $ids
     * @param string $query
     * @return array
     */
    public function load_multiselect_options($ids = array(), $query = '')
    {

        return RightPress_Conditions::get_all_states($ids, $query);
    }

    /**
     * Get placeholder
     *
     * @access public
     * @return string
     */
    public function get_placeholder()
    {

        return __('Select states', 'rightpress');
    }





}
