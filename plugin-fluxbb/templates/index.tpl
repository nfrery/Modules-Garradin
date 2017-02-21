{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="index"}

{if $error}
    <p class="error">
        {$error|escape}
    </p>
{/if}

{$te|escape}

{if !empty($liste_adherents_non_lie)}
    <p>Ensemble des membres n'ayant pas de compte sur le forum.</p>
    <table class="list">
        <thead>
            <tr>
                <td title="Numéro unique"></td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Ville</td>
                <td>Montant</td>
                <td>Date</td>
                <td>Télécharger</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        {foreach from=$trecus item="gendon"}
        <tr>
            <td>{$gendon.id|escape}</td>
            <td>{$gendon.nom|escape}</td>
            <td>{$gendon.prenom|escape}</td>
            <td>{$gendon.ville|escape}</td>
            <td>{$gendon.montant|escape}</td>
            <td>{$gendon.date|escape}</td>
            <td><a href="{plugin_url file="generation.php"}?id={$gendon.id}">{$gendon.gen_ordre|escape}.pdf</a></td>
            <td class="action">
                <a class="icn" href="{plugin_url file="supprimer.php"}?id={$gendon.id|escape}" title="Supprimer">✘</a>
            </td>
        </tr>
        {/foreach}
        </tbody>
    </table>
{else}
	<p class="alert">
        Tout les membres sont reliés à FluxBB.
    </p>
{/if}

{include file="admin/_foot.tpl"}
