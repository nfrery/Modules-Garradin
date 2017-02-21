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
        <legend>Droit à la réduction d'impôt</legend>
        <dl>
            <dt><label>Groupe pouvant gérer les votes:</label><b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><select name="groupe">
                    <option value="0">Admin</option>
                    <option value="1">Bureau</option>
                    <option value="2">Adhérents</option>
                    <option value="3">Autres</option>
                </select>
            </dd>
        </dl>
    </fieldset>
    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
</form> 

{include file="admin/_foot.tpl"}
