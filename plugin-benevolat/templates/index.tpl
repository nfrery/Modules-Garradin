{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="index"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}
{if $ok}
    <p class="confirm">{$ok|escape}</p>
{/if}

<table class="list">
    <caption>Les 5 dernières contributions ajoutées</caption>
    <thead>
    <td></td>
    <th>Bénévole</th>
    <td>Date</td>
    <td>Heures</td>
    <td>Taux horaire</td>
    <td>Catégorie</td>
    <td>Activité(s)</td>
    <td></td>
    </thead>
    <tbody>
    {foreach from=$liste_ben item="benevolat"}
        <tr>
            <td><a href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id|escape}">{$benevolat.id|escape}</a></td>
            {if $benevolat.id_membre != NULL}
                <th>{$benevolat.nom|escape}</th>
            {else}
                <th>{$benevolat.nom_prenom|escape}</th>
            {/if}
            <td>{$benevolat.date|escape}</td>
            <td class="num">{$benevolat.heures|escape}</td>
            <td class="num">{$benevolat.taux_horaire|html_money} {$config.monnaie|escape}/h</td>
            <td>{$benevolat.categorie|escape}</td>
            <td>{$benevolat.description_courte}{if strlen($benevolat.description) >= 30}…{/if}</td>
            <td class="actions">
                <a class="icn" href="{plugin_url file="benevolat_voir.php"}?id={$benevolat.id|escape}" title="Voir les enregistrements">𝍢</a>
                {if $user.droits.membres >= Garradin\Membres::DROIT_ADMIN}
                    <a class="icn" href="{plugin_url file="benevolat_modifier.php"}?id={$benevolat.id|escape}" title="Modifier">✎</a>
                    <a class="icn" href="{plugin_url file="benevolat_supprimer.php"}?id={$benevolat.id|escape}" title="Supprimer">✘</a>
                {/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>

    <form method="post" action="{$self_url|escape}">
        <fieldset>
            <legend>Ajouter une contribution bénévole</legend>
            <dl>
                <dt><label for="f_membre">Personne bénévole</label></dt>
                <dd>
                    <input list="lst_membre" type="text" id="f_membre" autocomplete="off" required="required" placeholder="Entrer les premières lettres du nom ou du prénom" size="50" >
                    <datalist id="lst_membre">
                    </datalist>
                    <input type="hidden" name="id_membre" id="f_membre-hidden">
                </dd>
                <dt><label for="f_date">Date du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="date" name="date" id="f_date" required="required"/></dd>

                <dt><label for="f_heure">Temps de bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="number" step="0.25" min="0" name="heure" placeholder="Durée en heure" id="f_heure" required="required"/></dd>

                <dt><label for="f_categorie">Catégorie du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dl class="catList">
                {foreach from=$liste_cat item="cat"}
                    <dt>
                    <input type="radio" name="id_categorie" value="{$cat.id|escape}" id="f_cat_{$cat.id|escape}" {form_field name="id_categorie" checked=$cat.id} required="required"/>
                    <label for="f_cat_{$cat.id|escape}">{$cat.nom|escape} à {$cat.taux_horaire}€/h</label>
                    </dt>
                    {if !empty($cat.description)}
                        <dd class="desc">{$cat.description|escape}</dd>
                    {/if}
                {/foreach}
                </dl>

                <dt><label for="f_description">Description de l'activité</label></dt>
                <dd><textarea name="description" id="f_description" rows="4" cols="30">{form_field name=description}</textarea></dd>
            </dl>
        </fieldset>

        <p class="submit">
            {csrf_field key="add_benevolat"}
            <input type="submit" name="add" value="Enregistrer &rarr;" />
        </p>
    </form>

<script type="text/javascript" src="{$admin_url}static/scripts/global.js"></script>
<script type="text/javascript" src="{$admin_url}static/scripts/datepickr.js"></script>
<link rel="stylesheet" type="text/css" href="{$admin_url}static/scripts/datepickr.css" />

{*Merci au créateur de plugin-matos pour cette partie*}
{literal}
<script type="text/javascript">

    document.querySelector('input[list]').addEventListener('input', function(e) {

        var input = e.target,
            list = input.getAttribute('list'),
            dataList = document.querySelector("#" + list),
            hiddenInput = document.getElementById(input.id + '-hidden');

        garradin.load('{/literal}{$self_url|escape}{literal}&q=' + escape(input.value), function(data) {

            dataList.innerHTML = '';

            var jsonOptions = JSON.parse(data);
            jsonOptions.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.value;
                option.innerHTML = item.value;
                option.setAttribute('data-value', item.id);
                dataList.appendChild(option);
            });
        });


        var selectedOption = document.querySelector("#" + list + " option[value='"+input.value+"']");

        if(selectedOption) {
            var value2send = selectedOption.getAttribute('data-value');
            if(value2send) {
                hiddenInput.value = value2send;
            } else {
                hiddenInput.value = '';
            }
        } else {
            hiddenInput.value = '';
        }
    });

    function fillDateRetour(elm)
    {
        var txtRetour = document.getElementById('f_date_retour');
        var dtePicker = document.forms[0].date_end;

        var selectedOption = elm.options[elm.selectedIndex];
        var days = parseInt(selectedOption.getAttribute('data-nbjours'));

        if(days > 0) {

            var datDeb = document.forms[0].date_begin;
            if(datDeb.value) {
                var dat = new Date(datDeb.value.toString());
            } else {
                var dat = new Date();
            }
            dat.setDate(dat.getDate() + days);

            txtRetour.value = dat.toLocaleDateString();
            dtePicker.value = dat.toISOString().split('T')[0];

        } else {

            txtRetour.value = '';
            dtePicker.value = '';

        }

    }
</script>
{/literal}

{include file="admin/_foot.tpl"}
