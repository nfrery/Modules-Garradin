{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="categorie"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<form method="post" action="{$self_url|escape}">
    <fieldset>
        <legend>Ajouter une catégorie</legend>
        <dl>
            <dt><label for="f_nom">Intitulé</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" name="nom" id="f_nom"/></dd>

            <dt><label for="f_taux">Taux horaire du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="number" step="0.01" min="0" name="taux" placeholder="Coût en €/h" id="f_taux"/></dd>

            <dt><label for="f_description">Description</label> </dt>
            <dd><textarea name="description" id="f_description" rows="4" cols="30" placeholder="">{form_field name=description}</textarea></dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="modif_categorie"}
        <input type="submit" name="add" value="Enregistrer &rarr;" />
    </p>
</form>
{include file="admin/_foot.tpl"}
