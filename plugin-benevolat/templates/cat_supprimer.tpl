{include file="admin/_head.tpl" title="Extension — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="categorie"}
{include file="%s/templates/_menu_categorie.tpl"|args:$plugin_root current="supprimer"}

{form_errors}

<form method="post" action="{$self_url}">

    <fieldset>
        <legend>Supprimer une catégorie</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer la catégorie «&nbsp;{$categorie.nom}&nbsp;» ?
        </h3>
        <p class="help">
            Attention, la catégorie ne pourra pas être supprimée si des heures de bénévolat y sont
            toujours affectées.
        </p>
    </fieldset>

    <p class="submit">
        {csrf_field key="cat_supprimer_%s"|args:$categorie.id}
        <input type="submit" name="delete" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}
