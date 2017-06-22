<?php
namespace Garradin\Plugin\MailChimp;

use Garradin\Plugin;
use Garradin\Membres;
use Garradin\UserException;

class Gestion
{
	public function __construct()
	{
	}

	protected static function ajoutMail($mail, $key, $id_list)
    {
        $MailChimp = new MailChimp($key);
        $result = $MailChimp->post("lists/$id_list/members", [
            'email_address' => $mail,
            'status'        => 'subscribed',
        ]);
        if ($MailChimp->success()) {
            return $result;
        } else {
            return $MailChimp->getLastError();
        }
    }

    protected static function supprMail($mail, $key, $id_list)
    {
        $MailChimp = new MailChimp($key);
        $subscriber_hash = $MailChimp->subscriberHash($mail);
        $MailChimp->delete("lists/$id_list/members/$subscriber_hash");
        if ($MailChimp->success()) {
            return true;
        } else {
            return $MailChimp->getLastError();
        }
    }

    public static function ajoutEditMembre($data)
    {
        $plugin = new Plugin('mailchimp');
        $key = $plugin->getConfig('key_api');
        $id_list = $plugin->getConfig('id_list');
        $id_formulaire = $plugin->getConfig('id_formulaire');

        if($key == "" || $id_list == "" || $id_formulaire == "")
        {
            return false;
        }

        $accord = $data['lettre_infos'];
        if($accord==true)
        {
            return Gestion::ajoutMail($data['email'], $key, $id_list);
        } elseif ($accord == false)
        {
            return Gestion::supprMail($data['email'], $key, $id_list);
        }
        return false;
    }

    public static function supprMembre($membres_id)
    {
        $plugin = new Plugin('mailchimp');
        $membre = new Membres();
        $key = $plugin->getConfig('key_api');
        $id_list = $plugin->getConfig('id_list');
        $del_membre = $plugin->getConfig('del_membre');
        if($key == "" || $id_list == "")
        {
            return false;
        }
        if($del_membre == true)
        {
            foreach ($membres_id as $id)
            {
                $mail = $membre->get($id);
                Gestion::supprMail($mail['email'],$key,$id_list);
            }

        } else {
            return true;
        }
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

}
?>