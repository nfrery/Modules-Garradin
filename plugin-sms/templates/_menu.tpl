<ul class="actions">
    <li{if $current == 'index'} class="current"{/if}><a href="{plugin_url file="index.php"}">SMS collectif</a></li>
    <li{if $current == 'rappels'} class="current"{/if}><a href="{plugin_url file="rappels.php"}">Rappels automatiques</a></li>
    {if $session->canAccess('config', Membres::DROIT_ADMIN)}
        <li{if $current == 'config'} class="current"{/if}><a href="{plugin_url file="config.php"}">Config</a></li>
    {/if}
    {if $plugin.config.soutien}
        <li{if $current == 'don'} class="current"{/if}><a href="{plugin_url file="don.php"}">Nous soutenir</a></li>
    {/if}
</ul>
