<ul class="actions">
    <li{if $current == 'index'} class="current"{/if}><a href="{plugin_url file="index.php"}">Vote en cours</a></li>
    <li{if $current == 'gestion'} class="current"{/if}><a href="{plugin_url file="gestion.php"}">Gérer des votes</a></li>
    <li{if $current == 'config'} class="current"{/if}><a href="{plugin_url file="config.php"}">Configuration</a></li>
</ul>
