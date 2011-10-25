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
 * Rucksack Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Greg Salt
 * @link		http://drylouvre.com
 */

$plugin_info = array(
	'pi_name'		=> 'Rucksack',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Greg Salt',
	'pi_author_url'	=> 'http://drylouvre.com',
	'pi_description'=> 'Rucksack',
	'pi_usage'		=> Rucksack::usage()
);


class Rucksack {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	public function store()
	{
		$key = $this->EE->TMPL->fetch_param('key');
		$data = $this->EE->TMPL->tagdata;

		$_SESSION['RUCKSACK'][$key] = $data;
	}

	// ----------------------------------------------------------------

	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

 Since you did not provide instructions on the form, make sure to put plugin documentation here.
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.rucksack.php */
/* Location: /system/expressionengine/third_party/rucksack/pi.rucksack.php */
