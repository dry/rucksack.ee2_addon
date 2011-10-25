<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Rucksack Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Greg Salt
 * @link		http://drylouvre.com
 */

class Rucksack_ext {
	
	public $settings 		= array();
	public $description		= 'Rucksack';
	public $docs_url		= '';
	public $name			= 'Rucksack';
	public $settings_exist	= 'n';
	public $version			= '1.0';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'sessions_start',
			'hook'		=> 'sessions_start',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------

	/**
	 * sessions_start
	 *
	 * @param 
	 * @return 
	 */
	public function sessions_start()
	{
		// Add Code for the sessions_start hook here.  
		session_start();
		register_shutdown_function('ob_end_flush');
		ob_start(array($this, 'buffer_handler'));
	}

	// ----------------------------------------------------------------------

	/**
	 * buffer_handler
	 *
	 * @access	public
	 * @return	string
	 */
	public function buffer_handler($buffer)
	{
		preg_match_all('/{rucksack:([a-z]+)}/U', $buffer, $matches, PREG_SET_ORDER);

		if (isset($matches))
		{
			$key = $matches[0][1];
			$matches[0][2] = $_SESSION['RUCKSACK'][$key];
			$buffer = str_replace($matches[0][0], $matches[0][2], $buffer);

			$cond = array();
			$cond['rucksack:'.$matches[0][1]] = TRUE;
			$this->EE->functions->prep_conditionals($buffer, $cond);
		}

		return $buffer;
	}
	
	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.rucksack.php */
/* Location: /system/expressionengine/third_party/rucksack/ext.rucksack.php */
