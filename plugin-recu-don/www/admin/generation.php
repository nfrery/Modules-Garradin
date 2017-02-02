<?php
namespace Garradin;

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
	$pdf->Write(0, '00001');
	$pdf->SetXY(20, 42);
	$pdf->Write(0, $config->get('nom_asso'));
	$pdf->SetXY(24,53);
	$pdf->Write(0, "10");
	$pdf->SetXY(42,53);
	$pdf->Write(0, utf8_decode("Avenue du vélo"));
	$pdf->SetXY(38,59);
	$pdf->Write(0, "10000");
	$pdf->SetXY(72,59);
	$pdf->Write(0, "Troyes");
	$pdf->SetXY(20,69);
	$pdf->Write(0, utf8_decode("Cette association a pour but la promotion de l'utilisation du vélo dans le cadre utilitaire et"));
	$pdf->SetXY(20,73);
	$pdf->Write(0, utf8_decode("quotidien de ses usagers et l'augmentation du nombre de cyclistes quotidiens dans de"));
	$pdf->SetXY(20,77);
	$pdf->Write(0, utf8_decode("bonnes conditions de sécurité et de fluidité dans l'agglomération troyenne."));
	$pdf->SetXY(19,135);
	$pdf->Write(0, "X");

	$pdf->AddPage();
	$tplIdx = $pdf->importPage(2);
	$pdf->useTemplate($tplIdx);

	$pdf->SetXY(18,25);
	$pdf->Write(0, "Anne");
	$pdf->SetXY(108,25);
	$pdf->Write(0, "Onyme");
	$pdf->SetXY(18,38);
	$pdf->Write(0, utf8_decode("43 rue du Fillon"));
	$pdf->SetXY(38,44);
	$pdf->Write(0, "10000");
	$pdf->SetXY(78,44);
	$pdf->Write(0, utf8_decode("Troyes"));
	$pdf->SetXY(85,69);	// Somme en chiffre
	$pdf->Write(0, utf8_decode("***5000***"));
	$pdf->SetXY(58,79);	// Somme en toute lettre
	$pdf->Write(0, utf8_decode("Cinq milles euros"));
	$pdf->SetXY(70,88);	// Jour du don
	$pdf->Write(0, "01");
	$pdf->SetXY(81,88);	// Mois du don
	$pdf->Write(0, "01");
	$pdf->SetXY(97,88);	// Année du don
	$pdf->Write(0, "1970");
	$pdf->SetXY(56.5,103);	// 200
	$pdf->Write(0, "X");
	$pdf->SetXY(106.5,103);	// 238 bis
	$pdf->Write(0, "X");
	$pdf->SetXY(156.5,103);	// 885-0 V bis A
	$pdf->Write(0, "X");
	$pdf->SetXY(119,120.5);	// Déclaration de don manuel
	$pdf->Write(0, "X");
	$pdf->SetXY(19,142.5);	// Numéraire
	$pdf->Write(0, "X");
	$pdf->SetXY(19,165);	// Remise d'espèces
	$pdf->Write(0, "X");
	$pdf->SetXY(61.5,165);	// Chèque
	$pdf->Write(0, "X");
	$pdf->SetXY(119,165);	// Virement, prélèvement, carte bancaire
	$pdf->Write(0, "X");
	$pdf->SetXY(143,245);	// Jour de l'édition du document
	$pdf->Write(0, "01");
	$pdf->SetXY(151,245);	// Mois de l'édition du document
	$pdf->Write(0, "01");
	$pdf->SetXY(158,245);	// Année de l'édition du document
	$pdf->Write(0, "1970");
	$pdf->Image(PLUGIN_ROOT . '/data/signature.png', 140, 247, 50 );	// Emplacement de la signature avec restriction de largeur pour tenir dans sur la case.
	$pdf->Output();