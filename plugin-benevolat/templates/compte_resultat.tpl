{include file="admin/_head.tpl" title="Extension — %s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id body_id="rapport" }
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="compte_resultat"}

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
                <tr class="parent">
                    <th>Emplois des contributions volontaires en nature</th>
                    <td class="money">{$benevolat.charges.total|escape|html_money}</td>
                </tr>
                <tr class="compte">
                    <th>Secours en nature</th>
                    <td><b class="money">{$benevolat.charges.bien.montant|escape|html_money}</b></td>
                </tr>
                <tr class="compte">
                    <th>Mise à disposition gratuite de biens et prestations</th>
                    <td><b class="money">{$benevolat.charges.presta.montant|escape|html_money}</b></td>
                </tr>
                <tr class="compte">
                    <th>Personnel bénévole</th>
                    <td><b class="money">{$benevolat.charges.benevolat.montant|escape|html_money}</b></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <tbody>
                <tr class="parent">
                    <th>Contributions volontaires en nature</th>
                    <td class="money">{$benevolat.produits.total|escape|html_money}</td>
                </tr>
                <tr class="compte">
                    <th>Dons en nature</th>
                    <td><b class="money">{$benevolat.produits.bien.montant|escape|html_money}</b></td>
                </tr>
                <tr class="compte">
                    <th>Prestations en nature</th>
                    <td><b class="money">{$benevolat.produits.presta.montant|escape|html_money}</b></td>
                </tr>
                <tr class="compte">
                    <th>Bénévolat</th>
                    <td><b class="money">{$benevolat.produits.benevolat.montant|escape|html_money}</b></td>
                </tr>
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

{include file="admin/_foot.tpl"}
