{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="other"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Supprimer une contribution bénévole</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer la contribution de «&nbsp;{$contribution.nom|escape}&nbsp;»
            du {$contribution.date} ?
        </h3>
    </fieldset>

    <p class="submit">
        {csrf_field key="ben_supprimer_`$contribution.id`"}
        <input type="submit" name="delete" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}
