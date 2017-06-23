{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="config"}

{if $error}
    {if $error == 'OK'}
        <p class="confirm">
            La configuration a bien été enregistrée.
        </p>
    {else}
        <p class="error">
            {$error|escape}
        </p>
    {/if}
{/if}


{include file="admin/_foot.tpl"}
