{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="index"}

{if $error}
    <p class="error">
        {$error|escape}
    </p>
{/if}

{if $ok}
    <p class="confirm">
        Le reçu numéro {$ordre|escape} a bien été crée.<br>
        Télécharger le reçu en PDF en <a href="{plugin_url file="generation.php"}?id={$ok|escape}">cliquant ici</a>.
    </p>
{/if}

<form method="post" action="{$self_url|escape}">
    <fieldset>
        <legend>Adresse du bénéficiaire</legend>
        <dl>
            <dt><label for="f_adresse">Adresse</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_adresse" name="adresse" required/></dd>
            <dt><label for="f_codepostal">Code postal</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_codepostal" name="codepostal" required/></dd>
            <dt><label for="f_ville">Ville</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_ville" name="ville" required/></dd>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Bénéficiaire</legend>
        <dl>
            <dt><label for="f_nom">Nom</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_nom" maxlength=100 name="nom" required/></dd>
            <dt><label for="f_prenom">Prénom</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_prenom" maxlength=100 name="prenom" required/></dd>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Informations du dons</legend>
        <dl>
            <dt><label for="f_ordre">Numéro d'ordre</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_ordre" name="numero"  required/></dd>
            <dt><label for="f_date">Date du don</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="date" name="date" id="f_date" value="{form_field name=date default=$date}" required/></dd>
            <dt><label for="f_montant">Montant du don</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="number" id="f_montant" min="0.00" step="0.01" name="montant" required/></dd>
            <dt><label>Mode de paiement</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd>
                <input type="radio" name="paiement" id="rb_especes" value="0" required/> <label for="rb_especes">Espèces</label><br>
                <input type="radio" name="paiement" id="rb_cheque" value="1"/> <label for="rb_cheque">Chèque</label><br>
                <input type="radio" name="paiement" id="rb_carte" value="2"/> <label for="rb_carte">Virement/Carte bancaire</label>   
            </dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="new_cat"}
        <input type="submit" name="save" value="Créer le reçu &rarr;"/>
    </p>
</form>

<a href="{plugin_url file="generation.php"}">Générer le pdf</a>
<br>
<a href="{plugin_url file="config.php"}">Configuration du plugin</a>


{include file="admin/_foot.tpl"}
