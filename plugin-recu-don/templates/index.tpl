{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="index"}

{if $error}
    {if $error == 'OK'}
    <p class="confirm">
        Le reçu numéro {$_POST['numero']} a bien été crée.<br>
        Télécharger le reçu en PDF en <a href="{plugin_url file="generation.php"}"."?id="."{$_POST['id']}">cliquant ici</a>.
    </p>
    {else}
    <p class="error">
        {$error|escape}
    </p>
    {/if}
{/if}


<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Adresse du bénéficiaire</legend>
        <dl>
            <dt>
                <label>
                    Adresse<br>
                    <input type="text" name="adresse" required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                    Code postal<br>
                    <input type="text" name="codepostal" required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                    Ville<br>
                    <input type="text" name="ville" required="required"/>
                </label>
            </dt>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Bénéficiaire</legend>
        <dl>
            <dt>
                <label>
                	Nom<br>
                    <input type="text" maxlength=100 name="nom"  required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                	Prénom<br>
                    <input type="text" maxlength=100 name="prenom" required="required"/>
                </label>
            </dt>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Informations du dons</legend>
        <dl>
            <dt>
                <label>
                    Numéro d'ordre<br>
                    <input type="text" maxlength=100 name="numero"  required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                    Date du don<br>
                    <input type="date" name="date" id="f_date" size="10" required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                    Montant du don<br>
                    <input type="number" min="0" name="montant" required="required"/>
                </label>
            </dt>
            <dt>
                <label>
                    Mode de paiement<br>
                    <input type="radio" name="paiement" value="0"/> Espèces<br>
                    <input type="radio" name="paiement" value="1"/> Chèque<br>
                    <input type="radio" name="paiement" value="2"/> Virement/Carte bancaire
                </label>
            </dt>
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
