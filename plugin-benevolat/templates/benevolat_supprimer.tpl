{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="benevolat"}
{include file="%s/templates/_menu_contribution.tpl"|args:$plugin_root current="supprimer"}

{form_errors}

<form method="post" action="{$self_url}">

    <fieldset>
        <legend>Supprimer une contribution bénévole</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer la contribution de «&nbsp;{if $contribution.id_membre != NULL}{$contribution.nom_membre}{else}{$contribution.nom_prenom}{/if}&nbsp;»
            du {$contribution.date} ?
        </h3>
    </fieldset>

    <p class="submit">
        {csrf_field key="ben_supprimer_%s"|args:$contribution.id}
        <input type="submit" name="delete" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}
