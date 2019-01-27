{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="index"}

{form_errors}

<fieldset>
    <legend>Exportation</legend>
    <dl>
        <dd><a href="{plugin_url}envoi_sms.php">SMS test</a></dd>
    </dl>
</fieldset>

{include file="admin/_foot.tpl"}
