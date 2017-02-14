{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="index"}

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

<form method="post" action="{$self_url|escape}">
    <fieldset>
        <legend>Connexion à FluxBB</legend>
        <dl>
        	<dt><label for="f_type">type:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_type" name="bdd_type" value="{form_field name=bdd_type data=$plugin.config }" required /></dd>
            <dt><label for="f_host">host:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_host" name="bdd_host" value="{form_field name=bdd_host data=$plugin.config }" required /></dd>
            <dt><label for="f_login">login:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_login" name="bdd_login" value="{form_field name=bdd_login data=$plugin.config }" required /></dd>
            <dt><label for="f_passwd">password:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="password" id="f_passwd" name="bdd_passwd" value="{form_field name=bdd_passwd data=$plugin.config }" required/></dd>
            <dt><label for="f_name">name:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_name" name="bdd_name" value="{form_field name=bdd_name data=$plugin.config }" required/></dd>
            <dt><label for="f_table">table:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_table" name="bdd_table" value="{form_field name=bdd_table data=$plugin.config }" required/></dd>
            <dt><label for="f_group">id groupe adhérents:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_group" name="bdd_group" value="{form_field name=bdd_group data=$plugin.config }" required/></dd>
        </dl>
    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
	</fieldset>
</form> 

{include file="admin/_foot.tpl"}
