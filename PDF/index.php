<?php
use setasign\Fpdi;
//use setasign\Fpdi\Fpdi;
//use setasign\Fpdi\PdfReader;

require_once('TCPDF-master/tcpdf.php');
//require_once('fpdf181/fpdf.php');
require_once('FPDI-2.2.0/src/autoload.php');

class Pdf extends Fpdi\TcpdfFpdi
{
    /**
     * "Remembers" the template id of the imported page
     */
    protected $tplId;

    /**
     * Draw an imported PDF logo on every page
     */
    function Header()
    {

    }

    function Footer()
    {

    }
}

function JuntarAssinaturaLaudo($nomelaudo = null, $nomeassinatura = null){
    if($nomelaudo == null || $nomeassinatura == null){
        return;
    }
    $pdf = new Pdf(); //FPDI extends TCPDF
    $pdf->AddPage();
    $pages = $pdf->setSourceFile('../uploads/laudo/'.$nomelaudo);
    $page = $pdf->ImportPage(1);
    $pdf->useTemplate($page, 0, 0);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Automatico');
    $pdf->SetTitle('Laudo');
    $html = '<img src="'.'../uploads/fotos/'.$nomeassinatura.'">';
    $pdf->writeHTMLCell(0, 0, '77', '230', $html, 0, 1, 0, true, '', true);
    $pdf->Output(dirname(__DIR__).'/uploads/laudo/'.$nomelaudo, 'F');
    return;
}

?>