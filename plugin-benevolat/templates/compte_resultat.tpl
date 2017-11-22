{if !isset($projet) AND !isset($exercice)}
    {include file="admin/_head.tpl" title="Compte de résultat — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id body_id="rapport" js=1}
    {include file="%s/templates/_menu.tpl"|args:$plugin_root current="compte_resultat"}
{else}
    {include file="admin/_head.tpl" title="Compte de résultat" body_id="rapport" js=1}
    <div class="exercice">
        <h2>{$config.nom_asso}</h2>
        {if isset($projet)}
            <h3>Projet&nbsp;: {$projet.libelle}</h3>
        {else}
            <p>Exercice comptable {if $exercice.cloture}clôturé{else}en cours{/if} du
                {$exercice.debut|date_fr:'d/m/Y'} au {$exercice.fin|date_fr:'d/m/Y'}, généré le {$cloture|date_fr:'d/m/Y'}</p>
        {/if}
    </div>

{/if}

{if !isset($projet) AND !isset($exercice)}
    <form method="get" action="{$self_url}" class="shortFormLeft">
        <fieldset>
            <legend>Filtrer par exercice</legend>
            <select name="exercice" id="f_exercice" onchange="this.form.submit();">
                <option value="0" selected="selected">Selectionner un exercice</option>
                {foreach from=$liste_exercices key="id" item="libelle"}
                        <option value="{$id}">{$libelle}</option>
                {/foreach}
            </select>
            <noscript><input type="submit" value="Filtrer &rarr;" /></noscript>
        </fieldset>
    </form>
    {if $liste_projets != null}
    <form method="get" action="{$self_url}" class="shortFormLeft">
        <fieldset>
            <legend>Filtrer par projet</legend>
            <select name="projet" id="f_projet" onchange="this.form.submit();">
                <option value="0" selected="selected">Selectionner un exercice</option>
                {foreach from=$liste_projets key="id" item="libelle"}
                    <option value="{$id}">{$libelle}</option>
                {/foreach}
            </select>
            <noscript><input type="submit" value="Filtrer &rarr;" /></noscript>
        </fieldset>
    </form>
    {/if}
{else}
<table>
    <colgroup>
        <col width="50%" />
        <col width="50%" />
    </colgroup>
    <tbody>
    <tr>
        <td>
            <table>
                <caption><h3>Charges</h3></caption>
                <tbody>
                {foreach from=$compte_resultat.charges.comptes key="parent_code" item="parent"}
                    <tr class="parent">
                        <th>{$parent_code|get_nom_compte}</th>
                        <td>{$parent.solde|escape|html_money}</td>
                    </tr>
                    {foreach from=$parent.comptes item="solde" key="compte"}
                        <tr class="compte">
                            <th>{$compte|get_nom_compte}</th>
                            <td>{$solde|escape|html_money}</td>
                        </tr>
                    {/foreach}
                {/foreach}
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <caption><h3>Produits</h3></caption>
                <tbody>
                {foreach from=$compte_resultat.produits.comptes key="parent_code" item="parent"}
                    <tr class="parent">
                        <th>{$parent_code|get_nom_compte}</th>
                        <td>{$parent.solde|escape|html_money}</td>
                    </tr>
                    {foreach from=$parent.comptes item="solde" key="compte"}
                        <tr class="compte">
                            <th>{$compte|get_nom_compte}</th>
                            <td>{$solde|escape|html_money}</td>
                        </tr>
                    {/foreach}
                {/foreach}
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
    <tbody>

    </tbody>
    <tfoot>
    <tr>
        <td>
            <table>
                <tfoot>
                <tr>
                    <th>Total charges</th>
                    <td>{$compte_resultat.charges.total|escape|html_money}</td>
                </tr>
                </tfoot>
            </table>
        </td>
        <td>
            <table>
                <tfoot>
                <tr>
                    <th>Total produits</th>
                    <td>{$compte_resultat.produits.total|escape|html_money}</td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tbody>
                {foreach from=$benevolat.charges.comptes key="parent_code" item="parent"}
                    <tr class="parent">
                        <th>{$parent_code|get_nom_compte}</th>
                        <td>{$parent.solde|escape|html_money}</td>
                    </tr>
                    {foreach from=$parent.comptes item="solde" key="compte"}
                        <tr class="compte">
                            <th>{$compte|get_nom_compte}</th>
                            <td>{$solde|escape|html_money}</td>
                        </tr>
                    {/foreach}
                {/foreach}
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <tbody>
                {foreach from=$benevolat.produits.comptes key="parent_code" item="parent"}
                    <tr class="parent">
                        <th>{$parent_code|get_nom_compte}</th>
                        <td>{$parent.solde|escape|html_money}</td>
                    </tr>
                    {foreach from=$parent.comptes item="solde" key="compte"}
                        <tr class="compte">
                            <th>{$compte|get_nom_compte}</th>
                            <td>{$solde|escape|html_money}</td>
                        </tr>
                    {/foreach}
                {/foreach}
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tfoot>
                <tr>
                    <th>Total charges général</th>
                    <td>{$benevolat.charges.general|escape|html_money}</td>
                </tr>
                </tfoot>
            </table>
        </td>
        <td>
            <table>
                <tfoot>
                <tr>
                    <th>Total produits général</th>
                    <td>{$benevolat.produits.general|escape|html_money}</td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            {if ($compte_resultat.resultat >= 0)}
                <table>
                    <tfoot>
                    <tr>
                        <th>Résultat (excédent)</th>
                        <td>{$compte_resultat.resultat|escape|html_money}</td>
                    </tr>
                    </tfoot>
                </table>
            {/if}
        </td>
        <td>
            {if ($compte_resultat.resultat < 0)}
                <table>
                    <tfoot>
                    <tr>
                        <th>Résultat (déficit)</th>
                        <td>{$compte_resultat.resultat|escape|html_money}</td>
                    </tr>
                    </tfoot>
                </table>
            {/if}
        </td>
    </tr>
    </tfoot>
</table>

<p class="help">Toutes les opérations sont libellées en {$config.monnaie}.</p>

{/if}

{include file="admin/_foot.tpl"}
