<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class Front_Auth {

	var	$useragent		= "CodeIgniter";
	var	$mailpath		= "/usr/sbin/sendmail";	// Sendmail path
	var	$protocol		= "mail";	// mail/sendmail/smtp


	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	function __construct()
    {
        parent::__construct();
        //$this->type=Cgh_assettype::article;
    }
	
	public function fndocheck($config = array())
	{	
		echo '>>>>>>>>>>>'; exit;
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
	}
	
	// --------------------------------------------------------------------

}
// END CI_Email class

/* End of file Email.php */
/* Location: ./system/libraries/Email.php */
