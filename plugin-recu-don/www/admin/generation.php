<?php
namespace Garradin;

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    throw new UserException("Le numéro du reçu fiscal est manquant.");
}

if (isset($_GET['ok']))
{
    $error = 'OK';
}

$id = (int) $_GET['id'];
$error = false;
$gendon = new Plugin\RecuDon\GenDon;

$recu = $gendon->get($id);

require_once(PLUGIN_ROOT . '/lib/fpdf/fpdf.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/pdf_context.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/pdf_parser.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/fpdi_pdf_parser.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/fpdi_bridge.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/fpdf_tpl.php');
require_once(PLUGIN_ROOT . '/lib/FPDI/fpdi.php');

	$pdf = new \FPDI();
	$pdf->AddPage();
	$pdf->setSourceFile(PLUGIN_ROOT . '/data/11580-03.pdf');
	$tplIdx = $pdf->importPage(1);
	$pdf->useTemplate($tplIdx);

	$pdf->SetFont('Helvetica');
	$pdf->SetTextColor(0);
	$pdf->SetXY(170,18);
	$pdf->Write(0, $recu['gen_ordre']);
	$pdf->SetXY(20, 42);
	$pdf->Write(0, $config->get('nom_asso'));
	$pdf->SetXY(24,53);
	$pdf->Write(0, utf8_decode($plugin->getConfig('numero_rue')));
	$pdf->SetXY(42,53);
	$pdf->Write(0, utf8_decode($plugin->getConfig('rue')));
	$pdf->SetXY(38,59);
	$pdf->Write(0, utf8_decode($plugin->getConfig('codepostal')));
	$pdf->SetXY(72,59);
	$pdf->Write(0, utf8_decode($plugin->getConfig('ville')));
	$pdf->SetXY(20,69);
	$pdf->Write(0, utf8_decode($plugin->getConfig('objet0')));
	$pdf->SetXY(20,73);
	$pdf->Write(0, utf8_decode($plugin->getConfig('objet1')));
	$pdf->SetXY(20,77);
	$pdf->Write(0, utf8_decode($plugin->getConfig('objet2')));
	$pdf->SetXY(19,135);
	$pdf->Write(0, "X");

	$pdf->AddPage();
	$tplIdx = $pdf->importPage(2);
	$pdf->useTemplate($tplIdx);

	$pdf->SetXY(18,25);
	$pdf->Write(0, $recu['nom']);
	$pdf->SetXY(108,25);
	$pdf->Write(0, $recu['prenom']);
	$pdf->SetXY(18,38);
	$pdf->Write(0, utf8_decode($recu['adresse']));
	$pdf->SetXY(38,44);
	$pdf->Write(0, $recu['codepostal']);
	$pdf->SetXY(78,44);
	$pdf->Write(0, utf8_decode($recu['ville']));
	$pdf->SetXY(85,69);	// Somme en chiffre
	$pdf->Write(0, utf8_decode("***".$recu['montant']."***"));
	$pdf->SetXY(58,79);	// Somme en toute lettre
	$pdf->Write(0, utf8_decode(numfmt_create('fr_FR', \NumberFormatter::SPELLOUT)->format($recu['montant'])) . ' euros');
	$date = date_parse($recu['date']);

	$pdf->SetXY(70,88);	// Jour du don
	$pdf->Write(0, $date['day']);
	$pdf->SetXY(81,88);	// Mois du don
	$pdf->Write(0, $date['month']);
	$pdf->SetXY(97,88);	// Année du don
	$pdf->Write(0, $date['year']);
	if($plugin->getConfig('droit_art200')){
		$pdf->SetXY(56.5,103);	// 200
		$pdf->Write(0, "X");
	}
	if($plugin->getConfig('droit_art238bis')){
		$pdf->SetXY(106.5,103);	// 238 bis
		$pdf->Write(0, "X");
	}
	if($plugin->getConfig('droit_art885-0VbisA')){
		$pdf->SetXY(156.5,103);	// 885-0 V bis A
		$pdf->Write(0, "X");
	}
	$pdf->SetXY(119,120.5);	// Déclaration de don manuel
	$pdf->Write(0, "X");
	$pdf->SetXY(19,142.5);	// Numéraire
	$pdf->Write(0, "X");
	switch ($recu['mode_paiement']){
		case 0:
			$pdf->SetXY(19,165);	// Remise d'espèces
			$pdf->Write(0, "X");
			break;

		case 1:
			$pdf->SetXY(61.5,165);	// Chèque
			$pdf->Write(0, "X");
			break;

		case 2:
			$pdf->SetXY(119,165);	// Virement, prélèvement, carte bancaire
			$pdf->Write(0, "X");
			break;
	}
	
	
	
	$pdf->SetXY(143,245);	// Jour de l'édition du document
	$pdf->Write(0, date('d'));
	$pdf->SetXY(151,245);	// Mois de l'édition du document
	$pdf->Write(0, date('m'));
	$pdf->SetXY(158,245);	// Année de l'édition du document
	$pdf->Write(0, date('y'));
	$pdf->Image(PLUGIN_ROOT . '/data/signature.png', 140, 247, 50 );	// Emplacement de la signature avec restriction de largeur pour tenir dans sur la case.
	$pdf->Output("D",$recu['gen_ordre'].".pdf");

	$tpl->assign('error', $error);
	$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');