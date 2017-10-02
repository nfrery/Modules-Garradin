{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="categorie"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Supprimer une catégorie</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer la catégorie «&nbsp;{$categorie.nom|escape}&nbsp;» ?
        </h3>
        <p class="help">
            Attention, la catégorie ne pourra pas être supprimée si des heures de bénévolat y sont
            toujours affectées.
        </p>
    </fieldset>

    <p class="submit">
        {csrf_field key="cat_supprimer_`$categorie.id`"}
        <input type="submit" name="delete" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}
