{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="index"}

{form_errors}
{if $ok}
    <p class="confirm">{$ok}</p>
{/if}

{if empty($liste_cat)}
    <p>Veuillez ajouter une <a href="{plugin_url}categorie.php">catégorie</a> pour pouvoir commencer à enregistrer des contributions bénévoles.</p>
{else}

<p>Note: Seul l'ajout d'un contribution d'un membre inscrit sur Garradin est actuellement possible.</p>
    <form method="post" action="{$self_url}">
        <fieldset>
            <legend>Ajouter une contribution bénévole</legend>
            <dl>
                <dt><label for="f_benevole_non_membre">Contribution réalisée par plusieurs membres </label><input type="checkbox" name="benevole_non_membre" id="f_benevole_non_membre"></dt>
                <dt class="nombenevole"><label for="f_nom_benevole">Noms et prénoms des bénévoles<b title="(Champ obligatoire)">obligatoire</b></label></dt>
                <dd class="nombenevole"><textarea name="nom_benevole" id="f_nom_benevole" rows="4" cols="30"></textarea></dd>
                <dt class="idbenevole"><label for="f_membre">Personne bénévole<b title="(Champ obligatoire)">obligatoire</b></label></dt>
                <dd class="idbenevole">
                    <input list="lst_membre" type="text" id="f_membre" autocomplete="off" required="required" placeholder="Entrer les premières lettres du nom ou du prénom" size="50">
                    <datalist id="lst_membre">
                    </datalist>
                    <input type="hidden" name="id_benevole" id="f_membre-hidden">
                </dd>
                <dt><label for="f_plage">Contribution sur plusieurs jours </label> <input type="checkbox" name="plage" id="f_plage"/></dt>
                <dt><label for="f_date">Date du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="date" name="date" id="f_date" required="required"/></dd>
                <dt class="date_fin"><label for="f_date_fin">Date de fin du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd class="date_fin"><input type="date" name="date_fin" id="f_date_fin"/></dd>
                <dt><label for="f_heure">Temps de bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dd><input type="number" step="0.25" min="0" name="nb_heures" placeholder="Durée en heure" id="f_heure"/></dd>

                <dt><label for="f_categorie">Catégorie du bénévolat</label> <b title="(Champ obligatoire)">obligatoire</b></dt>
                <dl class="catList">
                {foreach from=$liste_cat item="cat"}
                    <dt>
                    <input type="radio" name="id_categorie" value="{$cat.id}" id="f_cat_{$cat.id}" {form_field name="id_categorie" checked=$cat.id} required="required"/>
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
                                <option value="{$id}"{form_field name="projet" selected=$id}>{$libelle}</option>
                            {/foreach}
                        </select>
                    </dd>
                {/if}

                <dt><label for="f_description">Description de l'activité</label></dt>
                <dd><textarea name="description" id="f_description" rows="4" cols="30"></textarea></dd>
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
{/if}

{include file="admin/_foot.tpl"}
