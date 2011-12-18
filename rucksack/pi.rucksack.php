<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rucksack Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Greg Salt <greg@purple-dogfish.co.uk>
 * @link		http://purple-dogfish.co.uk
 */

$plugin_info = array(
	'pi_name' => 'Rucksack',
	'pi_version' => '1.0',
	'pi_author'	=> 'Greg Salt',
	'pi_author_url'	=> 'http://purple-dogfish.co.uk',
	'pi_description'=> 'Rucksack',
	'pi_usage' => Rucksack::usage()
);


class Rucksack {

	/**
	 * @access	public
	 * @var		string
	 */
	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	/**
	 * Store
	 *
	 * @access	public
	 * @return	void
	 */
	public function store()
	{
		$key = $this->EE->TMPL->fetch_param('key');
		$data = $this->EE->TMPL->tagdata;

		$_SESSION['RUCKSACK'][$key] = $data;
	}

	/**
	 * Plugin Usage
	 *
	 * @access	public
	 * @return	string
	 */
	public static function usage()
	{
		ob_start();
		?>
Store any data across page requests:
{exp:rucksack:store key="any_unique_key"}
...your data...
{/exp:rucksack:store}

Output that data again with:
{exp:rucksack:get key="the_unique_key"}
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.rucksack.php */
/* Location: /system/expressionengine/third_party/rucksack/pi.rucksack.php */
