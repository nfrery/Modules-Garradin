{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="categorie"}
{include file="%s/templates/_menu_categorie.tpl"|args:$plugin_root current="modifier"}

{form_errors}

<form method="post" action="{$self_url}">
    <fieldset>
        <legend>Modifier une catégorie</legend>
        <dl>
            <dt><label for="f_nom">Intitulé</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="nom" id="f_nom" value="{form_field name=nom data=$categorie}"/></dd>

            <dt><label for="f_taux">Taux horaire du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="number" step="0.01" min="0" name="taux_horaire" placeholder="Coût en €/h" id="f_taux" value="{form_field name=taux_horaire data=$categorie}"/></dd>

            <dt><label for="f_description">Description</label> </dt>
            <dd><textarea name="description" id="f_description" rows="4" cols="30" placeholder="">{form_field name=description data=$categorie}</textarea></dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="edit_categorie"}
        <input type="submit" name="add" value="Enregistrer &rarr;" />
    </p>
</form>
{include file="admin/_foot.tpl"}
