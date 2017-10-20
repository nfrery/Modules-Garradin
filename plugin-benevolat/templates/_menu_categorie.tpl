<ul class="actions">
    <li{if $current == 'categorie'} class="current"{/if}><a href="{plugin_url file="cat_voir.php?id=%s"|args:$categorie.id}">Catégorie: {$categorie.nom}</a></li>
    <li{if $current == 'modifier'} class="current"{/if}><a href="{plugin_url file="cat_modifier.php?id=%s"|args:$categorie.id}">Modifier la catégorie</a></li>
    <li{if $current == 'supprimer'} class="current"{/if}><a href="{plugin_url file="cat_supprimer.php?id=%s"|args:$categorie.id}">Supprimer la catégorie</a></li>
</ul>