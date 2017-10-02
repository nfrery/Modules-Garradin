{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="benevolat"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<table class="list">
    <thead>
    <th>Bénévole</th>
    <td>Date</td>
    <td>Heures</td>
    <td>Taux horaire</td>
    <td>Activité(s)</td>
    <td></td>
    </thead>
    <tbody>
    {foreach from=$liste item="benevolat"}
        <tr>
            {if $benevolat.id_membre != NULL}
                <th><a href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id_membre|escape}">{$benevolat.nom|escape}</a></th>
            {else}
                <th>{$benevolat.nom_prenom|escape}</th>
            {/if}
            <td>{$benevolat.date|escape}</td>
            <td class="num">{$benevolat.heures|escape}</td>
            <td class="num">{$benevolat.taux_horaire|html_money} {$config.monnaie|escape}/h</td>
            <td>{$benevolat.description}</td>
            <td class="actions">
                {if $user.droits.membres >= Garradin\Membres::DROIT_ADMIN}
                    <a class="icn" href="{plugin_url file="benevolat_modifier.php"}?id={$benevolat.id|escape}" title="Modifier">✎</a>
                    <a class="icn" href="{plugin_url file="benevolat_supprimer.php"}?id={$benevolat.id|escape}" title="Supprimer">✘</a>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="admin/_foot.tpl"}
