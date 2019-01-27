{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="config"}

{form_errors}

<form method="post" action="{$self_url}">
    <fieldset>
        <legend>Options:</legend>
        <dl>
            <dt><label for="f_soutien">Afficher la page <i>Nous soutenir</i></label> <input type="checkbox" name="soutien" id="f_soutien" value="1" {form_field name="soutien" checked=1 data=$plugin.config}/></dt>
            <dd>Vous pouvez soutenir l'association auteure de ce plugin sur <a href="https://www.helloasso.com/associations/troyes-en-selle/formulaires/1">HelloAsso</a>.</dd>
        </dl>

    </fieldset>
    <p class="submit">
        {csrf_field key="modif_config"}
        <input type="submit" name="config" value="Enregistrer &rarr;" />
    </p>
</form>

{include file="admin/_foot.tpl"}
