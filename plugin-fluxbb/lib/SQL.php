<?php
namespace Garradin\Plugin\FluxBB;

use Garradin;
use Garradin\Membres;
use Garradin\DB;
use Garradin\UserException;
use Garradin\Config;
use Garradin\Plugin;
use Garradin\Utils;

class SQL
{

    public function __construct()
    {

    }

    public function connexion()
    {
        $plugin = new \Garradin\Plugin('fluxbb');
        if($bdd = mysqli_connect($plugin->getConfig('bdd_host'),$plugin->getConfig('bdd_login'), $plugin->getConfig('bdd_passwd'), $plugin->getConfig('bdd_name')))
        {
            return $bdd;
        }
        else
        {
            return false;
        }
    }

    public function ajout_colonnes()
    {
        $bdd = connexion();
        $plugin = new \Garradin\Plugin('fluxbb');
        $requete = "ALTER TABLE ".$plugin->getConfig('bdd_table')."users ADD garradin_id INT(10) NULL UNIQUE;";
        $requete .= "ALTER TABLE ".$plugin->getConfig('bdd_table')."users ADD garradin_date INT(10) NULL UNIQUE;";
        $requete .= "ALTER TABLE ".$plugin->getConfig('bdd_table')."users ADD garradin_idjj INT(10) NULL UNIQUE;";
        mysqli_multi_query($bdd, $requete);
        mysqli_close($bdd);
    }

    public function suppression_colonnes()
    {
        $bdd = connexion();
        $plugin = new \Garradin\Plugin('fluxbb');
        $requete = "ALTER TABLE ".$plugin->getConfig('bdd_table')."users DROP garradin_id;";
        $requete .= "ALTER TABLE ".$plugin->getConfig('bdd_table')."users DROP garradin_date;";
        $requete .= "ALTER TABLE ".$plugin->getConfig('bdd_table')."users DROP garradin_idjj;";
        mysqli_multi_query($bdd, $requete);
        mysqli_close($bdd);
    }

    public function adhesionStart($id_fluxbb)
    {
        return null;
    }

    public function adhesionStop($id_fluxbb)
    {
        return null;
    }

    protected function ajoutUtilisateurFluxBB($id)
    {
        // Création du mot de passe avec KD2PassPhrase
        $password = Utils::suggestPassword();

        // Génération du pseudo grâce au nom et prénom sous la forme p.nom  (p=première lettre du prénom)
        $mb = new Membres();
        $membre_garradin = $mb->get($id);

        $tmp = explode(" ",$membre_garradin['nom'], 2);
        $username = substr($tmp[0], 0, 1).".".$tmp[1];

        // On vérifie que l'username n'existe pas déjà en base

        // sinon j'ajoute le numéro d'adhérent après le prénom
        //$username = substr($tmp[0], 0, 1).$id.".".$tmp[1];
        // en cas de pseudo toujours occupé, j'arrête le script

        // Inscription de l'utilisateur dans la base de données de FluxBB
        $plugin = new \Garradin\Plugin('fluxbb');
        $requete = "INSERT INTO ";
        $requete .= $plugin->getConfig('bdd_table')."users ";
        $requete .= "SET group_id=".$plugin->getConfig('bdd_group');
        $requete .= ", username='".$username;
        $requete .= "', password='".sha1($password);
        $requete .= "', email='".$membre_garradin['email'];
        $requete .= "', language='French',";
        $requete .=" registered='".date_timestamp_get(date_create())."';";
        $bdd = SQL::connexion();
        $curseur = mysqli_query($bdd, $requete);
        $garradin_id = mysqli_insert_id($bdd);

        // ajout de la liaison entre garradin et fluxBB
        $db = DB::getInstance();
        $requete1 = [
            'garradin_id'      =>  $membre_garradin['id'],
            'fluxbb_id'        =>  $garradin_id,
            'fluxbb_username'  =>  $username,
            'manuel'           =>  0
            ];
        $db->simpleInsert('plugin_fluxbb', $requete1);
        
        // Préparation d'un courriel de bienvenue sur le forum (à mettre dans la config plus tard pour faciliter l'édition)
        $dest   = "'".$membre_garradin['email']."'";
        $sujet  = "[Troyes en Selle] Un compte vient d'être crée sur notre forum";
        $corps  = "Bonjours,\nVous venez de cotiser pour devenir membre de Troyes en Selle, cela vous donne accès à notre forum, lieu d'échange et de discussion sur notre association.\nUn compte y a été créé pour vous afin de vous permettre l'accès à la zone reservée aux membres adhérents.\n\nPour vous connecter utilisez les informations suivantes:\nNom d'utilisateur: ".$username."\nMot de passe: ".$password."\n\nNous vous conseillons de changer votre mot de passe dès votre première connexion.\n\nMerci d'avoir adhérer à Troyes en Selle, c'est grâce à vous que nous pouvons défendre notre moyen de locomotion favori !";
        $entete = "From: no-reply@troyesenselle.fr\n";

        // Envoi du courriel
        mail($dest, $sujet, $corps, $entete);

        return true;
    }

    public function recherche_adherent($id)
    {

        // Je récupère les infos du membre sur garradin
        $mb = new Membres();
        $membre_garradin = $mb->get($id);
        $config = Config::getInstance();
        $db = DB::getInstance();
        $bdd = SQL::connexion();
        $plugin = new \Garradin\Plugin('fluxbb');
        // L'utilisateur est-il à jour de cotisation ?


        // Recheche si un utilisateur de fluxbb possède le mail d'un adhérent
        $requete = "SELECT id, username FROM ";
        $requete .= $plugin->getConfig('bdd_table')."users ";
        $requete .= "WHERE email=";
        $requete .= "'".$membre_garradin['email']."';";
        $curseur = mysqli_query($bdd, $requete);
        $data = mysqli_fetch_assoc($curseur);

        // Si c'est le cas je vérifie que le lien ne soit pas déjà fait et j'ajoute son id et son username dans la table plugin_fluxbb
        if(!empty($data)){
            if(empty($db->simpleQuerySingle('SELECT * FROM plugin_fluxbb WHERE garradin_id = ?;', true, (int) $id))){
                $requete1 = [
                'garradin_id'      =>  $membre_garradin['id'],
                'fluxbb_id'        =>  $data['id'],
                'fluxbb_username'  =>  $data['username'],
                'manuel'           =>  0
                ];
                print_r($requete1);
                $db->simpleInsert('plugin_fluxbb', $requete1);

                mysqli_close($bdd);
                print_r("L'utilisateur a été lié entre Garradin et FluxBB.");
            } else {
                mysqli_close($bdd);
                print_r("L'utilisateur est déjà lié entre Garradin et FluxBB.");
            }
        }
        else {
        // Dans le cas contraire je créer un compte sur le forum seulement si le membre est à jour de cotisation.
            mysqli_close($bdd);
            print_r("L'utilisateur n'existe pas sur le forum.");
            $bool = $this->ajoutUtilisateurFluxBB($id);
            return $bool;
        }
        
    }



    public function editManuel($id){
        $mb = new Membres();
        $membre_garradin = $mb->get($id);
        $config = Config::getInstance();
        $db = DB::getInstance();
        $bdd = SQL::connexion();
        $plugin = new \Garradin\Plugin('fluxbb');
        // Recheche si un utilisateur de fluxbb possède le mail d'un adhérent
        $requete = "SELECT id, username FROM ";
        $requete .= $plugin->getConfig('bdd_table')."users ";
        $requete .= "WHERE email=";
        $requete .= "'".$membre_garradin['email']."';";
        $curseur = mysqli_query($bdd, $requete);
        $data = mysqli_fetch_assoc($curseur);
        
        // Si c'est le cas je vérifie que le lien ne soit pas déjà fait et j'ajoute son id et son username dans la table plugin_fluxbb
        if(!empty($data)){
            $presence = false;
            if($presence == true){
                $requete1 = [
                'garradin_id'      =>  $membre_garradin['id'],
                'fluxbb_id'        =>  $data['id'],
                'fluxbb_username'  =>  $data['username'],
                'manuel'           =>  0
                ];
                print_r($requete1);
                $db->simpleInsert('plugin_fluxbb', $requete1);
                return $requete1['fluxbb_username'];
            }
            return "L'utilisateur est déjà lié entre Garradin et FluxBB";
        }
        else {
        // Dans le cas contraire je ne fais rien
            print_r("nonnon");
        }
        mysqli_close($bdd);
    }
}