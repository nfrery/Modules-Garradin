{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="config"}

{if $error}
    {if $error == 'OK'}
    <p class="confirm">
        La configuration a bien été enregistrée.
    </p>
    {else}
    <p class="error">
        {$error|escape}
    </p>
    {/if}
{/if}
<h1>Notice</h1>
<p>Pour utiliser cette extension vous devez possèder un compte sur <a href="https://mailchimp.com">MailChimp</a> et avoir créé une liste pour y stocker les mails de vos membres.<br>Entrez votre clé API (<a href="http://kb.mailchimp.com/fr/integrations/api-integrations/about-api-keys#Trouver-ou-créer-votre-propre-clé-API">disponible par ici</a>) et enregistrez le forumlaire pour afficher et sélectionner la liste qui vous intéresse.<br><br>
Afin de laisser le libre choix à vos membres, que ce soit au moment de l'adhésion ou via leur compte sur Garradin, vous devez ajouter un champ sur la fiche membres pour ne pas imposer une newslettre à un membre réfractaire.<br>Dans le menu <a href="http://garradin.troyesenselle.fr/admin/config/membres.php">Configuration</a> vous devez ajouter un champ de type « case à cocher » que vous pourrez sélectionner dans le formulaire.<br>
Quand la case sera cochée sur la fiche d'un membre, celui-ci se retrouvera inscrit sur votre liste d'envoi MailChimp.</p>

<form method="post" action="{$self_url|escape}">
    <fieldset>
        <legend>Paramètre MailChimp</legend>
        <dl>
        	<dt><label for="f_key_api">API Key</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_key_api" name="key_api" value="{form_field data=$plugin.config name=key_api}" /></dd>
            {if $listes != false}
            <dt><label for="f_id_list">Liste à utiliser</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd>
                <select name="id_list" id="f_id_list" required="required">
                {foreach from=$listes item=v}
                        <option value="{$v.id|escape}" {form_field data=$plugin.config name=id_list}>{$v.name|escape}</option>
                {/foreach}
                </select>
            </dd>
            {/if}
			<dt><label for="f_id_formulaire">Formulaire</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd>
            	<select name="id_formulaire" id="f_id_formulaire" required="required">
                {foreach from=$formulaires item="formulaire" key="nom"}
                    <option value="{$nom|escape}" {form_field data=$plugin.config name=id_formulaire}>{$nom|escape}</option>
                {/foreach}
                </select>
            </dd>
        </dl>
    </fieldset>
    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
</form> 

{include file="admin/_foot.tpl"}
