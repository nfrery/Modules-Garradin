{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="benevolat"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<table class="list">
    <thead>
    <td></td>
    <th>Bénévole</th>
    <td>Date</td>
    <td>Heures</td>
    <td>Taux horaire</td>
    <td>Catégorie</td>
    <td>Valorisé</td>
    <td>Activité(s)</td>
    <td></td>
    </thead>
    <tbody>
    {foreach from=$liste item="benevolat"}
        <tr>
            <td><a href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id|escape}">{$benevolat.id|escape}</a></td>
            {if $benevolat.id_membre != NULL}
                <th>{$benevolat.nom|escape}</th>
            {else}
                <th>{$benevolat.nom_prenom|escape}</th>
            {/if}
            {if $benevolat.plage == 'on'}
                <td>{$benevolat.date|escape} au<br>{$benevolat.date_fin}</td>
            {else}
                <td>{$benevolat.date|escape}</td>
            {/if}
            <td class="num">{$benevolat.heures|escape}</td>
            <td class="num">{$benevolat.taux_horaire|html_money} {$config.monnaie|escape}/h</td>
            <td>{$benevolat.categorie|escape}</td>
            <td class="num">{$benevolat.valorise|html_money} {$config.monnaie|escape}</td>
            <td>{$benevolat.description_courte}{if strlen($benevolat.description) >= 30}…{/if}</td>
            <td class="actions">
                <a class="icn" href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id|escape}" title="Voir les détails de la contribution.">𝍢</a>
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
