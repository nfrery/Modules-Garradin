{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="rappels"}

{form_errors}

<form method="post" action="{$self_url}">

    <fieldset>
        <legend>Supprimer ce rappel automatique ?</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer le rappel numéro «&nbsp;{$rappel.id}&nbsp;» ?
        </h3>
    </fieldset>

    <p class="submit">
        {csrf_field key="delete_rappel_"|cat:$rappel.id}
        <input type="submit" name="delete" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}
