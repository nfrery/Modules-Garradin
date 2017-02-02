{include file="admin/_head.tpl" title="Configuration — `$plugin.nom`" current="plugin_`$plugin.id`"}

{if $error}
    <p class="error">
        {$error|escape}
    </p>
{/if}

<form method="post" action="{$self_url|escape}">

    <fieldset>
        <legend>Configuration</legend>
        <dl>
            <dt>
                <label>
                    <input type="checkbox" name="display_hello" value="1" {form_field name="display_hello" checked=1 data=$plugin.config} />
                    Afficher un message de coucou
                </label>
            </dt>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="config_plugin_`$plugin.id`"}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>
</form>

{include file="admin/_foot.tpl"}
