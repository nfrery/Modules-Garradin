<ul class="actions">
    <li{if $current == 'index'} class="current"{/if}><a href="{plugin_url file="index.php"}">Ajouter un bénévolat</a></li>
    <li{if $current == 'benevolat'} class="current"{/if}><a href="{plugin_url file="benevolat.php"}">Voir les contributions</a></li>
    <li{if $current == 'categorie'} class="current"{/if}><a href="{plugin_url file="categorie.php"}">Catégorie</a></li>
    <li{if $current == 'config'} class="current"{/if}><a href="{plugin_url file="config.php"}">Config/Export</a></li>
    {if $plugin.config.soutien}
        <li{if $current == 'don'} class="current"{/if}><a href="{plugin_url file="don.php"}">Nous soutenir</a></li>
    {/if}
</ul>
