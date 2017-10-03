{include file="admin/_head.tpl" title="Extension — `$plugin.nom`" current="plugin_`$plugin.id`"}
{include file="`$plugin_root`/templates/_menu.tpl" current="other"}

{if $error}
    <p class="error">{$error|escape}</p>
{/if}
<form method="post" action="{$self_url|escape}">
    <fieldset>
        <legend>Modifier une contribution bénévole</legend>
        <dl>
            <dt><label for="f_membre">Personne bénévole</label></dt>
            <dd>
                <input list="lst_membre" type="text" id="f_membre" autocomplete="off" required="required" placeholder="Entrer les premières lettres du nom ou du prénom" size="50" value="{form_field name=nom data=$contribution}">
                <datalist id="lst_membre">
                </datalist>
                <input type="hidden" name="id_membre" id="f_membre-hidden" value="{form_field name=id_membre data=$contribution}">
            </dd>
            <dt><label for="f_plage">Contribution sur plusieurs jours</label> <input type="checkbox" name="plage" id="f_plage" {if $contribution.plage == 'on'}checked{/if}/></dt>
            <dt><label for="f_date">Date du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="date" name="date" id="f_date" required="required" value="{form_field name=date data=$contribution}"/></dd>
            <dt class="date_fin"><label for="f_date_fin">Date de fin du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd class="date_fin"><input type="date" name="date_fin" id="f_date_fin" value="{form_field name=date_fin data=$contribution}"/></dd>

            <dt><label for="f_heure">Temps de bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="number" step="0.25" min="0" name="heure" placeholder="Durée en heure" id="f_heure" value="{form_field name=heures data=$contribution}"/></dd>

            <dt><label for="f_categorie">Catégorie du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dl class="catList">
                {foreach from=$categories item="cat"}
                    <dt>
                        <input type="radio" name="id_categorie" value="{$cat.id|escape}" id="f_cat_{$cat.id|escape}" {form_field name="id_categorie" checked=$cat.id data=$contribution} />
                        <label for="f_cat_{$cat.id|escape}">{$cat.nom|escape} à {$cat.taux_horaire}€/h</label>
                    </dt>
                    {if !empty($cat.description)}
                        <dd class="desc">{$cat.description|escape}</dd>
                    {/if}
                {/foreach}
            </dl>

            <dt><label for="f_description">Description de l'activité</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><textarea name="description" id="f_description" rows="4" cols="30" >{form_field name=description}</textarea></dd>
        </dl>
    </fieldset>

    <p class="submit">
        {csrf_field key="edit_contribution"}
        <input type="submit" name="add" value="Enregistrer &rarr;" />
    </p>
</form>
<script type="text/javascript" src="{$admin_url}static/scripts/global.js"></script>
<script type="text/javascript" src="{$admin_url}static/scripts/datepickr.js"></script>
<link rel="stylesheet" type="text/css" href="{$admin_url}static/scripts/datepickr.css" />
<script type="text/javascript">
    {literal}
    (function () {
        window.changeTypeDuree = function()
        {
            var cb = $('#f_plage');
            var elm = $('#f_date_fin');
            if(cb.checked == true)
            {
                g.toggle('.date_fin', true);
                elm.required = true;
            }
            else
            {
                g.toggle('.date_fin', false);
                elm.required = false;
            }
        };

        changeTypeDuree();

        $('#f_plage').onchange = changeTypeDuree;
    } ());
    {/literal}
</script>
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