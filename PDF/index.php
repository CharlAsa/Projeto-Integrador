<?php
use setasign\Fpdi;

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
        /*
        if (is_null($this->tplId)) {
            $this->setSourceFile('logo.pdf');
            $this->tplId = $this->importPage(1);
        }
        $size = $this->useImportedPage($this->tplId, 130, 5, 60);

        $this->SetFont('freesans', 'B', 20);
        $this->SetTextColor(0);
        $this->SetXY(PDF_MARGIN_LEFT, 5);
        $this->Cell(0, $size['height'], 'TCPDF and FPDI');
        */
    }

    function Footer()
    {
        // emtpy method body
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
    $pdf->SetAuthor('Charles');
    $pdf->SetTitle('Laudo');
    $html = '<img src="'.'../uploads/fotos/'.$nomeassinatura.'">';
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output(dirname(__DIR__).'/uploads/laudo/'.$nomelaudo, 'F');
    return;
}

?>