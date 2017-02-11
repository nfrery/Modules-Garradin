{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="recu"}

{if $error}
    {if $error == 'OK'}
    <p class="confirm">
        La configuration a bien été enregistrée.
    </p>
    {else}
    <p class="error">
        {$error|escape}
    </p>
    {/if}
{/if}


{if !empty($trecus)}
    <p>Retrouvez l'ensemble des reçus fiscaux générés:</p>
    <table class="list">
        <thead class="userOrder">
            <tr>
                <td title="Numéro unique"></td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Ville</td>
                <td>Montant</td>
                <td>Date</td>
                <td>Télécharger</td>
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
        </tr>
        {/foreach}
        </tbody>
    </table>
{else}
    <p class="alert">
        Aucun reçu fiscal trouvé.
    </p>
{/if}

{include file="admin/_foot.tpl"}