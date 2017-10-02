{include file="admin/_head.tpl" title="Registre — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="registre"}


<table class="list">
    <colgroup>
        <col width="3%" />
        <col width="3%" />
        <col width="12%" />
        <col width="10%" />
    </colgroup>
    <thead>
        <tr>
            <th>Numéro Bicycode</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro pièce d'identité</th>
            <th>Date de marquage</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$liste item="marquage"}
        <tr>
            <td class="num">{$marquage.numero_bicycode}</td>
            <td>{$marquage.nom}</td>
            <td>{$marquage.prenom}</td>
            <td>{$marquage.numero_piece_identite}</td>
            <td>{$marquage.date_marquage}</td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                Aucune opération.
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>


{include file="admin/_foot.tpl"}
