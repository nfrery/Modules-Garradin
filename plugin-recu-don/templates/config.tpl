{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}
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

<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Adresse de l'association</legend>
        <dl>
            <dt>
                <label>
                    Numéro de rue<br>
                    <input type="text" maxlength=5 name="numero_rue" value="{form_field data=$plugin.config name=numero_rue}" />
                </label>
            </dt>
            <dt>
                <label>
                    Rue<br>
                    <input type="text" name="rue" value="{form_field data=$plugin.config name=rue}" />
                </label>
            </dt>
            <dt>
                <label>
                    Code postal<br>
                    <input type="text" name="codepostal" value="{form_field data=$plugin.config name=codepostal}" />
                </label>
            </dt>
            <dt>
                <label>
                    Ville<br>
                    <input type="text" name="ville" value="{form_field data=$plugin.config name=ville}" />
                </label>
            </dt>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Objet de l'association</legend>
        L'objet (but) de l'association doit tenir sur 3 lignes, chaque ligne pouvant accueillir un maximum de 100 caractères.
        <dl>
            <dt>
                <label>
                    <input type="text" maxlength=100 name="objet0" value="{form_field data=$plugin.config name=objet0}" />
                </label>
            </dt>
            <dt>
                <label>
                    <input type="text" maxlength=100 name="objet1" value="{form_field data=$plugin.config name=objet1}" />
                </label>
            </dt>
            <dt>
                <label>
                    <input type="text" maxlength=100 name="objet2" value="{form_field data=$plugin.config name=objet2}" />
                </label>
            </dt>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Droit à la réduction d'impôt prévue par les articles:</legend>
        <dl>
            <dt>
                <label>
                    Article 200
                    <input type="checkbox" name="droit_art200" {form_field name="droit_art200" checked=1 data=$plugin.config } />
                </label>
            </dt>
            <dt>
                <label>
                    Article 238 bis
                    <input type="checkbox" name="droit_art238bis" {form_field name="droit_art238bis" checked=1 data=$plugin.config } />
                </label>
            </dt>
            <dt>
                <label>
                    Article 885-0V bis A
                    <input type="checkbox" name="droit_art885-0VbisA" {form_field name="droit_art885-0VbisA" checked=1 data=$plugin.config } />
                </label>
            </dt>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Signature du responsable</legend>
        <dl>
            <dt><label>Signature en base64</label>
            <dd><input type="text" name="signaturetxt" value="{form_field name=signaturetxt data=$plugin.config }" /></dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
</form>

{include file="admin/_foot.tpl"}
