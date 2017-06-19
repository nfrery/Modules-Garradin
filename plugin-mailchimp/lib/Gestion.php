<?php
namespace Garradin\Plugin\MailChimp;

use Garradin;
use Garradin\Membres;
use Garradin\config;
use Garradin\Plugin;
use Garradin\Utils;
use Garradin\User;

class Gestion
{
	public function __construct()
	{
	}

	public function getLists()
	{
		$plugin = new Plugin('mailchimp');
		$key = $plugin->getConfig('key_api');
		$MailChimp = new MailChimp($key);
		$result = $MailChimp->get('lists');
		if ($MailChimp->success()) {
			return $result;
		} else {
			return $MailChimp->getLastError();
		}
	}

	public function getInfo()
	{
		$plugin = new Plugin('mailchimp');
		$key = $plugin->getConfig('key_api');
		$MailChimp = new MailChimp($key);
		$result = $MailChimp->get('lists');
		if ($MailChimp->success()) {
			return $result;
		} else {
			return $MailChimp->getLastError();
		}
	}

	public static function setMember($data)
	{
		
		$plugin = new Plugin('mailchimp');
		$membres = new Membres();
		if($plugin->getConfig('key_api') == "" || $plugin->getConfig('id_list') == "" || $plugin->getConfig('id_formulaire') == "")
		{
			return false;
		}

		$membre = $membres->get($data['id']);
		$email = $membre['email'];

		$key = $plugin->getConfig('key_api');
		$id_list = $plugin->getConfig('id_list');

		$MailChimp = new MailChimp($key);
		$result = $MailChimp->post("lists/$id_list/members", [
				'email_address' => $email,
				'status'        => 'subscribed',
			]);

		if ($MailChimp->success()) {
			return $result;
		} else {
			return $MailChimp->getLastError();
		}
	}
	public static function delMember($data)
	{
		$plugin = new Plugin('mailchimp');
		$membres = new Membres();

		if($plugin->getConfig('key_api') == "" || $plugin->getConfig('id_list') == "" || $plugin->getConfig('id_formulaire') == "")
		{
			return false;
		}

		$key = $plugin->getConfig('key_api');
		$id_list = $plugin->getConfig('id_list');

		$membre = $membres->get($data['id']);
		$email = $membre['email'];

		$MailChimp = new MailChimp($key);
		$subscriber_hash = $MailChimp->subscriberHash($email);
		$MailChimp->delete("lists/$id_list/members/$subscriber_hash");

		if ($MailChimp->success()) {
			return $true;
		} else {
			return $MailChimp->getLastError();
		}
	}
}
?>