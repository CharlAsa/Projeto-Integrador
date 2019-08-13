<?php

use setasign\Fpdi;
//use setasign\Fpdi\Fpdi;
//use setasign\Fpdi\PdfReader;

// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf.php');
//require_once('FPDI-2.2.0/src/fpdi.php');
//require_once('fpdf181/fpdf.php');
require_once('FPDI-2.2.0/src/autoload.php');
//require_once('FPDI-2.2.0/src/TcpdfFpdi.php');

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
    $pdf->SetAuthor('Automatico');
    $pdf->SetTitle('Laudo');
    $html = '<img src="'.'../uploads/fotos/'.$nomeassinatura.'">';
    $pdf->writeHTMLCell(0, 0, '77', '230', $html, 0, 1, 0, true, '', true);
    $pdf->Output(dirname(__DIR__).'/uploads/laudo/'.$nomelaudo, 'F');
    return;
}

function CriarPDF($nomelaudo = null, $nomeassinatura = null, $clinica = null, $laudo = null){
    if($nomelaudo == null || $nomeassinatura == null || $clinica == null || $laudo == null){
        return;
    }
    $pdf = new Pdf(); //FPDI extends TCPDF
    $pdf->AddPage();

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Automatico');
    $pdf->SetTitle('Laudo');

    $html = 
        '
        <p style="text-align:center;">'. $clinica->nome .'</p>
        <p style="text-align:center;">'. $clinica->especialidade .'</p>
        ';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $html = 
        '
        <p style="">Nome do Paciente: '. $laudo->consulta->paciente->nome . '</p>
        <p style="">Olho Esquerdo: '. $laudo->oe . '</p>
        <p style=""> Olho Direito: '. $laudo->od . '</p>
        <p style=""> Dp: '. $laudo->dp .'</p>
        <p style=""> Lentes: '. $laudo->lentes .'</p>
        <p style=""> Observações: '. $laudo->observacoes . '</p>
        <p style=""> Nova Consulta:'. $laudo->nova_consulta .'</p>
        ';

    $pdf->writeHTMLCell(0, 0, '', '50', $html, 0, 1, 0, true, '', true);

    $html = 
        '
        <img src="'.'../uploads/fotos/'.$nomeassinatura.'">
        ';

    $pdf->writeHTMLCell(0, 0, '77', '200', $html, 0, 1, 0, true, '', true);

    $html = 
        '
        <p style="text-align:center;">' . $laudo->consulta->medico->nome . ' - ' . '$laudo->consulta->medico->especialidade' . ' - ' . $laudo->consulta->medico->crm . '</p>
        <p style="text-align:center;"> ' .  $clinica->logradouro . ' - ' . '$clinica->cep' . ' - ' . $clinica->cidade . ' - ' . '$clinica->estado' . ' </p>
        <p style="text-align:center;"> ' . $clinica->telefone . ' - ' . $clinica->email . '</p>
        ';

    $pdf->writeHTMLCell(0, 0, '0', '250', $html, 0, 1, 0, true, '', true);
    
    $pdf->Output(dirname(__DIR__).'/uploads/laudo/'.$nomelaudo, 'F');

    return;
}

?>