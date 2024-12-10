<?php

require_once "../controllers/CartController.php";
require_once "../pdf/fpdf.php";
require_once "../controllers/mail.php";


function send_invoice($id_cart)
{
    $cartController = new CartController();
    $cart = $cartController->getOrderDetails($id_cart);
    $date = $cart[0]['date_cart'];
    $montant = $cart[0]['total'];
    $email_content = array(
        'Subject' => 'Nouvelle Commande',
        'body' => "Bonjour Mr/Mme ,
           Vous Avez Une Nouvelle Commande : <br>
           Date : $date<br>
           Montant : $montant TND<br>
           Vous trouverez ci-dessous votre facture <br>
           cordialement,"
    );
    $pdf = new FPDF();
    $pdf->AddPage();

    // Ajouter le logo
    $pdf->Image('images/logo.jpg', 10, 10, 30); // Chemin du logo
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Cell(190, 10, 'Facture', 0, 1, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(190, 10, 'Technovateur', 0, 1, 'C');
    $pdf->Cell(190, 5, 'Adresse : Esprit, El Ghazela, Ariana', 0, 1, 'C');
    $pdf->Cell(190, 5, 'Contact : +216 29 481 355 | contact@technovateur.tn', 0, 1, 'C');
    $pdf->Ln(10);

    // Informations de la facture
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(100, 10, 'Facture #: ' . $_GET['id_cart'], 0, 0);
    $pdf->Cell(90, 10, 'Date : ' . date('Y-m-d'), 0, 1);

    // Ajouter une ligne
    $pdf->Ln(5);
    $pdf->Cell(190, 0, '', 'T', 1, 'C');
    $pdf->Ln(5);

    // Détails de la commande
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(100, 10, 'Description', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Quantite', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Prix Unit.', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total', 1, 1, 'C');

    $pdf->SetFont('Times', '', 12);
    foreach ($cart as $detail) { // Exemple de structure
        $pdf->Cell(100, 10, $detail['name'], 1, 0);
        $pdf->Cell(30, 10, $detail['quantite'], 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($detail['price'], 2) . " TND", 1, 0, 'R');
        $pdf->Cell(30, 10, number_format($detail['quantite'] * $detail['price'], 2) . " TND", 1, 1, 'R');
    }

    $pdf->Cell(160, 10, 'Total :', 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($montant, 2) . " TND", 1, 1, 'R');

    $pdf->Ln(10);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(190, 10, 'Merci pour votre confiance !', 0, 1, 'C');

    $fileName = "factures/Facture_#" . $_GET["id_cart"] . ".pdf";
    $pdf->Output('F', $fileName);
    sendemail($cart[0]['email'], $email_content, $fileName);
    $cartController->updateStatus($id_cart, "Confirmé");
    header("Location: shop.php");
}
