<?php
/**
 *
 * Change Username. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Steyn Van Houte
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace blaatpraat\username\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Change Username Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'				=> 'load_language_on_setup',
			'core.modify_username_string'	=> 'get_username'
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper	$helper		Controller helper object
	 * @param \phpbb\template\template	$template	Template object
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->helper = $helper;
		$this->template = $template;
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function get_username($event)
	{
		$newName = 'testUser';
		
		$usernameString = $event['username_string'];
		$plainUsername = $event['username'];
		$newUsername = str_replace($plainUsername, $newName, $usernameString);
		$event['username'] = $newName;
		$event['username_string'] = $newUsername;
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'blaatpraat/username',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
