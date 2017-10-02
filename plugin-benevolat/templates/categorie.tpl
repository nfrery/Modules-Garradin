{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="categorie"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}

{if $ok}
    <p class="confirm">{$ok|escape}</p>
{/if}

<table class="list">
    <thead>
    <th>Intitulé</th>
    <td>Description</td>
    <td>Taux horaire</td>
    <td>Heures enregistrées</td>
    <td></td>
    </thead>
    <tbody>
    {foreach from=$liste item="benevolat"}
        <tr>
            <th><a href="{plugin_url file="cat_voir.php"}?id={$benevolat.id|escape}">{$benevolat.nom|escape}</a></th>
            <td>{$benevolat.description}</td>
            <td class="num">{$benevolat.taux_horaire|html_money} {$config.monnaie|escape}/h</td>
            <td class="num">{$benevolat.nb_heures|escape}</td>
            <td class="actions">
                <a class="icn" href="{plugin_url file="cat_voir.php"}?id={$benevolat.id|escape}" title="Voir les enregistrements">𝍢</a>
                {if $user.droits.membres >= Garradin\Membres::DROIT_ADMIN}
                    <a class="icn" href="{plugin_url file="cat_modifier.php"}?id={$benevolat.id|escape}" title="Modifier">✎</a>
                    <a class="icn" href="{plugin_url file="cat_supprimer.php"}?id={$benevolat.id|escape}" title="Supprimer">✘</a>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>

    <form method="post" action="{$self_url|escape}">
        <fieldset>
            <legend>Ajouter une catégorie</legend>
            <dl>
                <dt><label for="f_nom">Intitulé</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="text" name="nom" id="f_nom"/></dd>

                <dt><label for="f_taux">Taux horaire du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="number" step="0.01" min="0" name="taux" placeholder="Coût en €/h" id="f_taux"/></dd>

                <dt><label for="f_description">Description</label> </dt>
                <dd><textarea name="description" id="f_description" rows="4" cols="30" placeholder="">{form_field name=description}</textarea></dd>
            </dl>
        </fieldset>

        <p class="submit">
            {csrf_field key="add_categorie"}
            <input type="submit" name="add" value="Enregistrer &rarr;" />
        </p>
    </form>
{include file="admin/_foot.tpl"}
