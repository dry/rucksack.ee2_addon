<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rucksack Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Greg Salt <greg@purple-dogfish.co.uk>
 * @link		http://purple-dogfish.co.uk
 */
class Rucksack_ext {
	
	/**
	 * @access	public
	 * @var		array
	 */
	public $settings = array();

	/**
	 * @access	public
	 * @var		string
	 */
	public $description = 'Rucksack';

	/**
	 * @access	public
	 * @var		string
	 */
	public $docs_url = '';

	/**
	 * @access	public
	 * @var		string
	 */
	public $name = 'Rucksack';

	/**
	 * @access	public
	 * @var		string
	 */
	public $settings_exist = 'n';

	/**
	 * @access	public
	 * @var		string
	 */
	public $version	= '1.0';
	
	/**
	 * @access	private
	 * @var		ExpressionEngine
	 */
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
	}

	/**
	 * Activate Extension
	 *
	 * @access	public
	 * @return	void
	 */
	public function activate_extension()
	{
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

	/**
	 * sessions_start
	 *
	 * @access	public
	 * @param	object	Session
	 * @return	void 
	 */
	public function sessions_start(&$session)
	{
		session_start();
		register_shutdown_function('ob_end_flush');
		ob_start(array($this, 'buffer_handler'), $chunk_size = 0, $erase = TRUE);
	}

	/**
	 * buffer_handler
	 *
	 * @access	public
	 * @param	string	Output buffer
	 * @return	string
	 */
	public function buffer_handler($buffer)
	{
		$pattern = '/{rucksack:get\s+key=[\'"](.+)[\'"]}/U';
		$count = preg_match_all($pattern, $buffer, $matches, PREG_SET_ORDER);

		if ($count)
		{
			$key = $matches[0][1];
			$value = $_SESSION['RUCKSACK'][$key];
			$buffer = str_replace($matches[0][0], $value, $buffer);

			$cond = array();
			$cond['rucksack:'.$key] = TRUE;
			$this->EE->functions->prep_conditionals($buffer, $cond);
		}

		return $buffer;
	}
	
	/**
	 * Disable Extension
	 *
	 * @access	public
	 * @return	void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	/**
	 * Update Extension
	 *
	 * @access	public
	 * @return 	mixed	Void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
}

/* End of file ext.rucksack.php */
/* Location: /system/expressionengine/third_party/rucksack/ext.rucksack.php */
