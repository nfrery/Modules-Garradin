{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}

<p>Cette extension n'est qu'un test.</p>


<a href="generation.php">Générer le pdf</a>

    <fieldset>
        <legend>Informations sur l'association</legend>
        <dl>
            <dt><label for="f_nom_asso">Nom</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="nom_asso" id="f_nom_asso" required="required" value="{form_field data=$config name=nom_asso}" /></dd>
            <dt><label for="f_email_asso">Adresse E-Mail</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="email" name="email_asso" id="f_email_asso" required="required" value="{form_field data=$config name=email_asso}" /></dd>
            <dt><label for="f_adresse_asso">Adresse postale</label></dt>
            <dd><textarea cols="50" rows="5" name="adresse_asso" id="f_adresse_asso">{form_field data=$config name=adresse_asso}</textarea></dd>
            <dt><label for="f_site_asso">Site web</label></dt>
            <dd><input type="url" name="site_asso" id="f_site_asso" value="{form_field name=site_asso data=$config}" /></dd>
        </dl>
    </fieldset>

<h3>Récupération des informations sur l'adresse de l'association et son nom</h3>
   {if !empty($config.nom_asso)}
    <p>
        {$config.nom_asso|escape|nl2br}
    </p>
    {/if}
    test {$machin}


{include file="admin/_foot.tpl"}
