{include file="admin/_head.tpl" title="Modifier un rappel automatique" current="membres/cotisations" js=1}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="rappels"}

{form_errors}

<form method="post" action="{$self_url}" id="f_add">

    <fieldset>
        <legend>Modifier un rappel automatique</legend>
        <dl>
            <dt><label for="f_id_cotisation">Cotisation associée</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd>
                <select name="id_cotisation" id="f_id_cotisation" required="required">
                    <option value="">--</option>
                    {foreach from=$cotisations item="co"}
                        <option value="{$co.id}" {form_field name="id_cotisation" selected=$co.id data=$rappel}>
                            {$co.intitule}
                            — {$co.montant|escape|html_money} {$config.monnaie}
                            — {if $co.duree}pour {$co.duree} jours
                            {elseif $co.debut}
                                du {$co.debut|format_sqlite_date_to_french} au {$co.fin|format_sqlite_date_to_french}
                            {else}
                                ponctuelle
                            {/if}
                        </option>
                    {/foreach}
                </select>
            </dd>
            <dt><label for="f_delai">Délai d'envoi</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><label><input type="radio" name="delai_choix" value="0" {form_field name="delai_choix" checked=0 default=0 data=$rappel} /> Le jour de l'expiration de la cotisation</label></dd>
            <dd>
                <input type="radio" name="delai_choix" id="f_delai_pre" value="-1" {form_field name="delai_choix" checked=-1 data=$rappel} />
                <input type="number" name="delai_pre" id="f_delai_pre_nb" step="1" min="1" max="900" size="4" id="f_delai" value="{form_field name=delai_pre data=$rappel default=30}" />
                <label for="f_delai_pre">jours avant expiration</label>
            </dd>
            <dd>
                <input type="radio" name="delai_choix" id="f_delai_post" value="1" {form_field name="delai_choix" checked=1 data=$rappel} />
                <input type="number" name="delai_post" id="f_delai_post_nb" step="1" min="1" max="900" size="4" id="f_delai" value="{form_field name=delai_post default=30 data=$rappel}" />
                <label for="f_delai_post">jours après expiration</label>
            </dd>
            <dt><label for="f_texte">Texte du mail</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><textarea name="texte" id="f_texte" cols="70" rows="15" required="required">{form_field name=texte data=$rappel}</textarea></dd>
            <dt><label>Estimation du coût</label></dt>
            <dd>112 caractères, 3 sms et 12 destinataires</dd>
            <dd>23 crédits sur 50 crédits restants</dd>
            <dd class="help">Astuce : pour inclure dans le contenu du SMS le nom du membre, utilisez #IDENTITE, pour inclure le délai de l'envoi utilisez #NB_JOURS.</dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="edit_rappel_%s"|args:$rappel.id}
        <input type="submit" name="save" value="Enregistrer &rarr;" />
    </p>

</form>

{include file="admin/_foot.tpl"}