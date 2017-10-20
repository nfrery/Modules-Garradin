{include file="admin/_head.tpl" title="Extension — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="index"}

{form_errors}
{if $ok}
    <p class="confirm">{$ok}</p>
{/if}

<h1>Attention</h1>
<p>Ce plugin est en pleine refonte. Les futurs contributions bénévoles seront directement intégrées dans la comptabilité de Garradin (actuellement le journal n'est pas rempli).</p>
<p>C'est pourquoi il faut pour l'instant éviter d'ajouter des contributions bénévoles sur le formulaire ci-dessous. Le développeur travail pour sortir une nouvelle version le plus rapidement possible.</p>

    <form method="post" action="{$self_url}">
        <fieldset>
            <legend>Ajouter une contribution bénévole</legend>
            <dl>
                <dt><label for="f_membre">Personne bénévole</label></dt>
                <dd>
                    <input list="lst_membre" type="text" id="f_membre" autocomplete="off" required="required" placeholder="Entrer les premières lettres du nom ou du prénom" size="50" >
                    <datalist id="lst_membre">
                    </datalist>
                    <input type="hidden" name="id_benevole" id="f_membre-hidden">
                </dd>
                <dt><label for="f_plage">Contribution sur plusieurs jours</label> <input type="checkbox" name="plage" id="f_plage"/></dt>
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
{*Merci au créateur de plugin-matos pour cette partie*}
{literal}
<script type="text/javascript">

    document.querySelector('input[list]').addEventListener('input', function(e) {

        var input = e.target,
            list = input.getAttribute('list'),
            dataList = document.querySelector("#" + list),
            hiddenInput = document.getElementById(input.id + '-hidden');

        garradin.load('{/literal}{$self_url}{literal}?q=' + escape(input.value), function(data) {

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
</script>
{/literal}

{include file="admin/_foot.tpl"}
