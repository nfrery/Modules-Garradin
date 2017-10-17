{include file="admin/_head.tpl" title="Configuration — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="config"}

{form_errors}

<p>Partie à venir (configuration de votre code Bicycode et listage des numéros encore disponibles)</p>

{include file="admin/_foot.tpl"}
