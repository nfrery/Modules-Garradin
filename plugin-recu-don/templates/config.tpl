{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="config"}

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
            <dt><label for="f_numero_rue">Numéro de rue</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_numero_rue" maxlength=5 name="numero_rue" value="{form_field data=$plugin.config name=numero_rue}" /></dd>
            <dt><label for="f_rue">Rue</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_rue" name="rue" value="{form_field data=$plugin.config name=rue}" /></dd>
            <dt><label for="f_codepostal">Code postal</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_codepostal" name="codepostal" value="{form_field data=$plugin.config name=codepostal}" /></dd>
            <dt><label for="f_ville">Ville</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" id="f_ville" name="ville" value="{form_field data=$plugin.config name=ville}" /></dd>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Objet de l'association</legend>
        <dl>
            <dt><label>L'objet (but) de l'association doit tenir sur 3 lignes, chaque ligne pouvant accueillir un maximum de 100 caractères.</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="text" maxlength=100 name="objet0" value="{form_field data=$plugin.config name=objet0}" /></dd>
            <dd><input type="text" maxlength=100 name="objet1" value="{form_field data=$plugin.config name=objet1}" /></dd>
            <dd><input type="text" maxlength=100 name="objet2" value="{form_field data=$plugin.config name=objet2}" /></dd>
        </dl>
    </fieldset>

    <fieldset>
        <legend>Droit à la réduction d'impôt</legend>
        <dl>
            <dt><label>Articles conernés par l'association:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dt><input type="checkbox" name="droit_art200" {form_field name="droit_art200" checked=1 data=$plugin.config } /><label>Article 200</label></dt>
            <dt><input type="checkbox" name="droit_art238bis" {form_field name="droit_art238bis" checked=1 data=$plugin.config } /><label>Article 238 bis</label></dt>
            <dt><input type="checkbox" name="droit_art885-0VbisA" {form_field name="droit_art885-0VbisA" checked=1 data=$plugin.config } /><label>Article 885-0V bis A</label></dt>
        </dl>
    </fieldset>

   

    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
</form> 

<form method="post" enctype="multipart/form-data" action="{$self_url|escape}" id="f_upload">
    <fieldset>
        <legend>Signature du responsable</legend>

        L'image de la signature doit être au format PNG, d'une taille raisonable et doit être dotée d'un fond transparent.

        <input type="hidden" name="MAX_FILE_SIZE" value="{$max_size|escape}" id="f_maxsize" />
        <dl>
            <dd class="help">Taille maximale : {$max_size|format_bytes}</dd>
            <dd class="fileUpload"><input type="file" name="fichier" id="f_fichier" data-hash-check /></dd>
        </dl>
        <p class="submit">
            {csrf_field key="signature"}
            <input type="submit" name="upload" id="f_submit" value="Envoyer le fichier" />
        </p>
    </fieldset>
</form>

{include file="admin/_foot.tpl"}
