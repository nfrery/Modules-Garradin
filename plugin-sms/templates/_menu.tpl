<ul class="actions">
    <li{if $current == 'index'} class="current"{/if}><a href="{plugin_url file="envoi_sms.php"}">Envoi SMS</a></li>
    {if $session->canAccess('config', Membres::DROIT_ADMIN)}
        <li{if $current == 'config'} class="current"{/if}><a href="{plugin_url file="config.php"}">Config/Export</a></li>
    {/if}
    {if $plugin.config.soutien}
        <li{if $current == 'don'} class="current"{/if}><a href="{plugin_url file="don.php"}">Nous soutenir</a></li>
    {/if}
</ul>
