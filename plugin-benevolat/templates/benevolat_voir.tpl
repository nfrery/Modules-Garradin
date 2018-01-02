{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="benevolat"}
{include file="%s/templates/_menu_contribution.tpl"|args:$plugin_root current="contribution"}

{if $edit == 'ok'}
    <p class="confirm">La contribution a bien été mise à jour.</p>
{/if}

<dl class="describe">
<dt><label>Personne bénévole</label></dt>
    {if $contribution.id_benevole != NULL}
        <dd>{if $session->canAccess('compta', Garradin\Membres::DROIT_ACCES)}
                <a href="{$admin_url}membres/fiche.php?id={$contribution.id_benevole}">{$contribution.nom_membre}</a>
            {else}
                {$contribution.nom_membre}
            {/if}</dd>
    {else}
        <dd>{$contribution.nom_benevole}</dd>
    {/if}
    <dt><label>Date</label></dt>
    {if $contribution.plage == 'on'}
        <dd>{$contribution.date} au {$contribution.date_fin}</dd>
    {else}
        <dd>{$contribution.date}</dd>
    {/if}
    <dt><label>Durée</label></dt>
    <dd>{$contribution.heures} heures</dd>
    <dt><label>Catégorie</label></dt>
    <dd><a href='{plugin_url}cat_voir.php?id={$contribution.id_categorie}'>{$contribution.categorie}</a> à {$contribution.taux_horaire}€/h</dd>
    <dt><label>Bénévolat valorisé</label></dt>
    <dd>{$contribution.valorise}€</dd>
    <dt><label>Description de l'activité</label></dt>
    {if $contribution.description != NULL}
        <dd>{$contribution.description}</dd>
    {else}
        <dd>Aucune description</dd>
    {/if}
    <dt>Exercice</dt>
    <dd>
        <a href="{$admin_url}compta/exercices/">{$exercice.libelle}</a>
        | Du {$exercice.debut|date_fr:'d/m/Y'} au {$exercice.fin|date_fr:'d/m/Y'}
        | <strong>{if $exercice.cloture}Clôturé{else}En cours{/if}</strong>
    </dd>
    {if $contribution.id_projet}
        <dt>Projet</dt>
        <dd>
            <a href="{$admin_url}compta/projets/">{$contribution.libelle_projet}</a>
        </dd>
    {/if}
    <dt><label>Membre ayant ajouté cette contribution</label></dt>
    <dd>
        {if $contribution.id_auteur}
            {if $session->canAccess('compta', Garradin\Membres::DROIT_ACCES)}
                <a href="{$admin_url}membres/fiche.php?id={$contribution.id_auteur}">{$contribution.nom_auteur}</a>
            {else}
                {$contribution.nom_auteur}
            {/if}
        {else}
            <em>membre supprimé</em>
        {/if}
    </dd>
</dl>

{include file="admin/_foot.tpl"}
