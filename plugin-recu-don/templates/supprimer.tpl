{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="recu"}

{if $error}
    <p class="error">
        {$error|escape}
    </p>
{/if}

<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Supprimer ce reçu fiscal ?</legend>
        <h3 class="warning">
            Êtes-vous sûr de vouloir supprimer le reçu fiscal n°{$recu.gen_ordre|escape} concernant un don de {$recu.montant} € effectué par {$recu.prenom} {$recu.nom} le {$recu.date} ?
        </h3>
    </fieldset>

    <p class="submit">
        {csrf_field key="recu_supprimer_`$recu.id`"}
        <input type="submit" name="remove" value="Supprimer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}