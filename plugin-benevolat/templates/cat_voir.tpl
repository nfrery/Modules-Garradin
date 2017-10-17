{include file="admin/_head.tpl" title="Extension — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="benevolat"}

{form_errors}

<table class="list">
    <thead>
    <th>Bénévole</th>
    <td>Date</td>
    <td>Heures</td>
    <td>Taux horaire</td>
    <td>Valorisé</td>
    <td>Activité(s)</td>
    <td></td>
    </thead>
    <tbody>
    {foreach from=$liste item="benevolat"}
        <tr>
            {if $benevolat.id_membre != NULL}
                <th><a href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id_membre}">{$benevolat.nom}</a></th>
            {else}
                <th>{$benevolat.nom_prenom}</th>
            {/if}
            {if $benevolat.plage == 'on'}
                <td>{$benevolat.date} au<br>{$benevolat.date_fin}</td>
            {else}
                <td>{$benevolat.date}</td>
            {/if}

            <td class="num">{$benevolat.heures}</td>
            <td class="num">{$benevolat.taux_horaire} {$config.monnaie}/h</td>
            <td class="num">{$benevolat.valorise} {$config.monnaie}</td>
            <td>{$benevolat.description}</td>
            <td class="actions">
                {if $session->canAccess('membres', Garradin\Membres::DROIT_ADMIN)}
                    <a class="icn" href="{plugin_url file="benevolat_modifier.php"}?id={$benevolat.id}" title="Modifier">✎</a>
                    <a class="icn" href="{plugin_url file="benevolat_supprimer.php"}?id={$benevolat.id}" title="Supprimer">✘</a>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="admin/_foot.tpl"}
