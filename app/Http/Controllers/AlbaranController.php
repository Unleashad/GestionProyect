<?php

namespace App\Http\Controllers;

use App\Mail\Message;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;

class AlbaranController extends Controller
{
    public function sendPDF(Request $request){

        $servicio = Servicio::where('id', $request->servicio_id)->with('obra.cliente.email')->get();
        $servicio = $servicio[0];

        $emails =  $this->buildToEmails($servicio->obra->cliente->email);

        $nameFile = $servicio->obra->nombre.'-'.explode(' ', $servicio->fecha)[0].'.pdf';
        $this->buildPDF($servicio->id)->Output('F', 'storage/TempPdf/'.$nameFile);
        
        Mail::send('mail', [], function ($message) use($emails, $servicio){
            $files = File::allFiles('storage/TempPdf');

            $filePath = $files[0]->getRealPath();
            
            $message->bcc($emails);
            $message->subject('Albaran '.$servicio->obra->nombre.' - '.$this->prepareFecha($servicio->fecha));
            $message->attach($filePath);
        });

        $deletePath = File::allFiles('storage/TempPdf');
        File::delete($deletePath[0]->getRealPath());

    }

    public function downloadPDF(Request $request){

        header("Access-Control-Allow-Origin: *");
        $this->buildPDF($request->servicio_id)->Output('I');
    }


    private function buildPDF(int $id){

        $servicio = Servicio::where('id', $id)->get();
        $servicio = $servicio[0];

        $fecha = $this->prepareFecha($servicio->fecha);
        
        $fpdi = new FPDI;
        $path = Storage::disk('local')->path('public/albaran1.pdf');
        $fpdi->setSourceFile($path);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);

        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);

        $fpdi->SetFont("arial", "", 11);

        //Header
        $fpdi->Text(175, 44, utf8_decode($servicio->numeracion));
        $fpdi->Text(60, 56, utf8_decode($servicio->maquina->matricula));
        $fpdi->Text(150, 56, utf8_decode($servicio->maquina->tipo));
        $fpdi->Text(40, 69, utf8_decode($servicio->trabajador->nombre.' '.$servicio->trabajador->apellidos));


        //Main Zone
        $fpdi->Text(60, 88.5, utf8_decode($servicio->obra->cliente->nombre));
        $fpdi->Text(155, 88.5, utf8_decode($servicio->obra->cliente->cif));
        $fpdi->Text(60, 100, utf8_decode($servicio->obra->cliente->localidad.' - '.explode('-', $servicio->obra->cliente->provincia)[1]));
        $fpdi->Text(155, 100, utf8_decode($servicio->obra->cliente->telefono));
        $fpdi->Text(60, 111, utf8_decode($servicio->obra->direccion.', '.$servicio->obra->nombre));
        $fpdi->Text(45, 114, utf8_decode($servicio->observaciones));


        //Second Zone
        $fpdi->Text(50, 156, utf8_decode($servicio->desplazamiento));
        $fpdi->Text(50, 168, utf8_decode($servicio->m3));
        $fpdi->Text(60, 179, utf8_decode(explode(' ', $servicio->hora_ini)[1]));
        $fpdi->Text(150, 179, utf8_decode(explode(' ', $servicio->hora_fin)[1]));
        $fpdi->Text(60, 190, utf8_decode(round((strtotime($servicio->hora_fin) - strtotime($servicio->hora_ini))/3600)));

        //Bottom Zone
        $fpdi->SetFont("arial", "", 9);
        $fpdi->Text(97, 292, utf8_decode($fecha));
        $fpdi->Text(20, 270, utf8_decode('Nombre: '.$servicio->nombreFirmante)); //NOMBRE FIRMANTE
        $fpdi->Text(20, 274, utf8_decode('Dni: '.$servicio->dni));

        $temDir = (new TemporaryDirectory())->create();
        $pathToSign = $temDir->path('using.png');
        $encodedImg = explode(',', $servicio->firmaCliente)[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($pathToSign, $decodedImg);
        $fpdi->Image($pathToSign, 45, 274 ,40);

        $temDir = (new TemporaryDirectory())->create();
        $pathToSign = $temDir->path('using.png');
        $encodedImg = explode(',', $servicio->trabajador->firmaUser)[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($pathToSign, $decodedImg);
        $fpdi->Image($pathToSign, 170, 270 ,40);

        return $fpdi;
    }

    private function buildToEmails($e){

        $emailsFinal = array();

        foreach ($e as $email) {
            $emailsFinal[] = $email->correo_cliente;
        }

        return $emailsFinal;
    }

    private function prepareFecha($f){

        $meses = 
        [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
            'Noviembre', 'Diciembre'
        ];

        $fecha = explode(' ', $f)[0];
        $fecha = explode('-', $fecha);
        $fecha = $fecha[2].' de '.$meses[intval($fecha[1]-1)].' de '.$fecha[0];

        return $fecha;
    }
}
