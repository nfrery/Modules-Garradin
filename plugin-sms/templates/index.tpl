{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="index"}

{form_errors}

<p class="help">
    Les messages seront envoyés aux membres qui n'ont pas d'adresse email et qui ont un numéro de téléphone portable.
</p>
{*
<form method="post" action="{$self_url}">
    <fieldset class="memberMessage">
        <legend>Message</legend>
        <dl>
            <dt>Destinataires</dt>
            <dd>
                <select name="recipients">
                    <optgroup label="Catégorie de membres">
                        {foreach from=$categories key="id" item="nom"}
                            <option value="categorie_{$id}" {form_field name="recipients" selected="categorie_%d"|args:$id}>{$nom}</option>
                        {/foreach}
                    </optgroup>
                    <optgroup label="Recherche de membres">
                        {foreach from=$recherches item="r"}
                            <option value="recherche_{$r.id}" {form_field name="recipients" selected="recherche_%d"|args:$r.qid}>{$r.intitule}</option>
                        {/foreach}
                    </optgroup>
                </select>
            </dd>
            {* FIXME : pas encore possible, en attente de refonte gestion cotisations
            <dd>
                <label><input type="checkbox" name="paid_members_only" value="1" {form_field name="paid_members_only" checked=1 default=1} />
                    Seulement les membres à jour de cotisation
                </label>
            </dd>

            <dt><label for="f_message">Message</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><textarea name="message" id="f_message" cols="72" rows="25" required="required">{form_field name=message}</textarea></dd>

            <dt><label>Estimation du coût</label></dt>
            <dd>112 caractères, 3 sms et 12 destinataires</dd>
            <dd>23 crédits sur 50 crédits restants</dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="send_message_co"}
        <input type="submit" name="send" value="Envoyer &rarr;" />
    </p>
</form>*}

{include file="admin/_foot.tpl"}
