{include file="admin/_head.tpl" title="Extension — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="index"}

{form_errors}

<form method="post" action="{$self_url}">
    <fieldset>
        <legend>Enregistrer un marquage</legend>
        <dl>
            <dt><label for="f_numero_bicycode">Numéro Bicycode</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="numero" name="numero_bicycode" maxlength="12" id="f_numero_bicycode"/></dd>
            <dt><label for="f_date_marquage">Date de marquage</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="date_marquage" id="f_date_marquage"/></dd>
            <dt><label for="f_nom">Nom</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="nom" id="f_nom"/></dd>
            <dt><label for="f_prenom">Prénom</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="prenom" id="f_prenom"/></dd>
            <dt><label for="f_adresse">Adresse</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="adresse" id="f_adresse"/></dd>
            <dt><label for="f_code_postal">Code postal</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="code_postal" id="f_code_postal"/></dd>
            <dt><label for="f_ville">Ville</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="ville" id="f_ville"/></dd>
            <dt><label for="f_telephone">Téléphone</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="telephone" id="f_telephone"/></dd>
            <dt><label for="f_numero_piece_identite">Numéro pièce d'identité</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="numero_piece_identite" id="f_numero_piece_identite"/></dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="add_marquage"}
        <input type="submit" name="add" value="Enregistrer &rarr;" />
    </p>
</form>

{include file="admin/_foot.tpl"}
