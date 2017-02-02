{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}

<p>Cette extension n'est qu'un test.</p>

{if $plugin.config.display_hello}
	<h3>Coucou tu veux voir mon extension ?</h3>
{/if}


{include file="admin/_foot.tpl"}
