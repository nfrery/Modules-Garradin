{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="benevolat"}
{include file="%s/templates/_menu_contribution.tpl"|args:$plugin_root current="modifier"}

{form_errors}
<form method="post" action="{$self_url}">
    <fieldset><legend>Ajouter une contribution bénévole</legend>
        <dl>
            <dt><label>Contribution réalisée par plusieurs membres </label><input type="checkbox" name="benevole_non_membre" id="f_benevole_non_membre"></dt>
            <dt class="nombenevole"><label for="f_nom_benevole">Noms et prénoms des bénévoles<b title="(Champ obligatoire)">obligatoire</b></label></dt>
            <dd class="nombenevole"><textarea name="nom_benevole" id="f_nom_benevole" rows="4" cols="30">{form_field name=nom_benevole data=$contribution}</textarea></dd>
            <dt class="idbenevole"><label for="f_membre">Personne bénévole<b title="(Champ obligatoire)">obligatoire</b></label></dt>
            <dd class="idbenevole">
                <input list="lst_membre" type="text" id="f_membre" autocomplete="off" required="required" placeholder="Entrer les premières lettres du nom ou du prénom" size="50" value="{form_field name=nom_membre data=$contribution}">
                <datalist id="lst_membre">
                </datalist>
                <input type="hidden" name="id_benevole" id="f_membre-hidden" value="{form_field name=id_benevole data=$contribution}">
            </dd>
            <dt><label for="f_plage">Contribution sur plusieurs jours</label> <input type="checkbox" name="plage" id="f_plage" {if $contribution.plage == 'on'}checked{/if}/></dt>
            <dt><label for="f_date">Date du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="date" name="date" id="f_date" required="required" value="{form_field name=date data=$contribution}"/></dd>
            <dt class="date_fin"><label for="f_date_fin">Date de fin du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd class="date_fin"><input type="date" name="date_fin" id="f_date_fin" value="{form_field name=date_fin data=$contribution}"/></dd>

            <dt><label for="f_heure">Temps de bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><input type="number" step="0.25" min="0" name="nb_heures" placeholder="Durée en heure" id="f_heure" value="{form_field name=heures data=$contribution}"/></dd>

            <dt><label for="f_categorie">Catégorie du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dl class="catList">
                {foreach from=$categories item="cat"}
                    <dt>
                        <input type="radio" name="id_categorie" value="{$cat.id}" id="f_cat_{$cat.id}" {form_field name="id_categorie" checked=$cat.id data=$contribution} />
                        <label for="f_cat_{$cat.id}">{$cat.nom} à {$cat.taux_horaire}€/h</label>
                    </dt>
                    {if !empty($cat.description)}
                        <dd class="desc">{$cat.description}</dd>
                    {/if}
                {/foreach}
            </dl>

            {if count($projets) > 0}
                <dt><label for="f_projet">Projet</label></dt>
                <dd>
                    <select name="projet" id="f_projet">
                        <option value="0">-- Aucun</option>
                        {foreach from=$projets key="id" item="libelle"}
                            <option value="{$id}"{form_field name=id_projet data=$contribution selected=$id}>{$libelle}</option>
                        {/foreach}
                    </select>
                </dd>
            {/if}

            <dt><label for="f_description">Description de l'activité</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
            <dd><textarea name="description" id="f_description" rows="4" cols="30" >{form_field name=description data=$contribution}</textarea></dd>
        </dl>
        <input type="hidden" value="{$contribution.id_compta}">
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
            if(cb.checked === true)
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

        window.changeBenevole = function()
        {
            var cb = $('#f_benevole_non_membre');
            var nom = $('#f_nom_benevole');
            var id = $('#f_membre');
            var id_ben = $('#f_membre-hidden');
            if(cb.checked === true)
            {
                g.toggle('.nombenevole', true);
                g.toggle('.idbenevole', false);
                nom.required = true;
                id.required = false;
                id.value = "";
                id_ben.value = null;
            }
            else {
                g.toggle('.nombenevole', false);
                g.toggle('.idbenevole', true);
                nom.required = false;
                id.required = true;
                nom.value = "";
            }
        };

        window.test = function ()
        {
            var cb = $('#f_benevole_non_membre');
            var nom = $('#f_nom_benevole');
            var id = $('#f_membre');
            var id_ben = $('#f_membre-hidden');
            if('{/literal}{form_field name=nom_membre data=$contribution}{literal}' === '')
            {
                g.toggle('.nombenevole', true);
                g.toggle('.idbenevole', false);
                nom.required = true;
                id.required = false;
                id_ben.value = null;
                cb.checked = true;
            }
        };

        test();
        changeTypeDuree();
        changeBenevole();

        $('#f_plage').onchange = changeTypeDuree;
        $('#f_benevole_non_membre').onchange = changeBenevole;
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
        if(input.value.length > 2)
        {
            garradin.load('{/literal}{$self_url}{literal}&q=' + encodeURI(input.value), function(data)
            {
                dataList.innerHTML = '';
                var jsonOptions = JSON.parse(data);
                jsonOptions.forEach(function (item)
                {
                    console.log(dataList);
                    var option = document.createElement('option');
                    option.value = item.value;
                    option.innerHTML = item.value;
                    option.setAttribute('data-value', item.id);
                    dataList.appendChild(option);
                });
                var option = document.createElement('option');
                option.value = input.value;
                option.innerHTML = input.value;
                option.setAttribute('data-value', 0);
                dataList.appendChild(option);
            });
        }
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
</script>
{/literal}

{include file="admin/_foot.tpl"}
