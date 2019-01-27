{include file="admin/_head.tpl" title="%s"|args:$plugin.nom current="plugin_%s"|args:$plugin.id}
{include file="%s/templates/_menu.tpl"|args:$plugin_root current="don"}

<h1>Vous aimez cette extension ?</h1>
<p>Alors n'hésitez pas à nous soutenir pour que les membres de l'association <a href="https://troyesenselle.fr">Troyes en Selle</a> puissent continuer à maintenir et créer de nouvelles extensions pour Garradin.</p>
<p>L'ensemble des modules réalisés par et pour l'association Troyes en Selle est disponible sur <a href="https://github.com/nfrery/Modules-Garradin">ce dépôt Github</a>.

    <iframe id="haWidget" src="https://www.donnerenligne.fr/troyes-en-selle/faire-un-don" style="width:800px;height:750px;border:none;"></iframe>

    {include file="admin/_foot.tpl"}
