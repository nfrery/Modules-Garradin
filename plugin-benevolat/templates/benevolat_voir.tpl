{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="benevolat"}


        <dl class="describe">
            <dt><label>Personne bénévole</label></dt>
            <dd>{$contribution.nom}</dd>
            <dt><label>Date du bénévolat</label></dt>
            <dd>{$contribution.date}</dd>
            <dt><label>Temps de bénévolat</label></dt>
            <dd>{$contribution.heures} heures</dd>
            <dt><label>Catégorie du bénévolat</label></dt>
            <dd>{$contribution.categorie} à {$contribution.taux_horaire}€/h</dd>
            <dt><label>Bénévolat valorisé</label></dt>
            <dd>{$contribution.valorise}€</dd>
            <dt><label>Description de l'activité</label></dt>
            <dd>{$contribution.description}</dd>
            <dt><label>Membre ayant ajouté cette contribution</label></dt>
            <dd>{$contribution.nom_membre_ajout}</dd>
            <dt><label>Dernier membre ayant modifié cette contribution</label></dt>
            <dd>{$contribution.nom_membre_modif}</dd>
        </dl>


{include file="admin/_foot.tpl"}
