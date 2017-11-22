<ul class="actions">
    <li{if $current == 'contribution'} class="current"{/if}><a href="{plugin_url file="benevolat_voir.php?id=%s"|args:$contribution.id}">Contribution n°{$contribution.id}</a></li>
    {if $session->canAccess('membres', Garradin\Membres::DROIT_ADMIN) OR $session->getUser()->id == $contribution->id_membre}
        <li{if $current == 'modifier'} class="current"{/if}><a href="{plugin_url file="benevolat_modifier.php?id=%s"|args:$contribution.id}">Modifier ce bénévolat</a></li>
    {/if}
    {if $session->canAccess('membres', Garradin\Membres::DROIT_ADMIN)}
        <li{if $current == 'supprimer'} class="current"{/if}><a href="{plugin_url file="benevolat_supprimer.php?id=%s"|args:$contribution.id}">Supprimer ce bénévolat</a></li>
    {/if}
</ul>