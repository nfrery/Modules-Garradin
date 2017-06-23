{include file="admin/_head.tpl" title="Registre — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="registre"}


<table class="list">
    <colgroup>
        <col width="3%" />
        <col width="3%" />
        <col width="12%" />
        <col width="10%" />
    </colgroup>
    <tbody>
    {foreach from=$liste item=v}
        <tr>
            <td class="num">{$v.numero_bicycode|escape}</td>
            <td>{$v.nom|escape}</td>
            <td></td>
            <td></td>
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
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>


{include file="admin/_foot.tpl"}
