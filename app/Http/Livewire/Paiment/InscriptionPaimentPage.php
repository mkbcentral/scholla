<?php

namespace App\Http\Livewire\Paiment;

use App\Models\Inscription;
use App\Models\ScolaryYear;
use Livewire\Component;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class InscriptionPaimentPage extends Component
{
    public $date_to_search;
    public $taux=2000;
    public $inscription;
    public $paiment_date;

    public function mount(){
        $this->currenetDate=date('y-m-d');
        $this->date_to_search=$this->currenetDate;
    }
    public function refreshData(){
        $this->date_to_search=date('y-m-d');
    }

    public function edit(Inscription $inscription){
        $this->inscription=$inscription;
    }

    public function update(){
        $this->validate(['paiment_date'=>'required|date']);
        $this->inscription->created_at=$this->paiment_date;
        $this->inscription->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Date bien mise à jour"]);
    }

    public function testPrint(Inscription $paiement){
        try {
            $connector = new WindowsPrintConnector("EPSON TM-T20II Receipt5");
            $printer = new Printer($connector);
            $logo = EscposImage::load("logo.png", false);

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            //$printer -> graphics($logo);
            $printer -> selectPrintMode(Printer::MODE_FONT_A);
            $printer -> text("COMPLEX SCOLAIRE AQUILA\n");
            $printer -> text("Golf Plateau \n");
            $printer -> text("Q.MUKUNTO C/ANNEXE\n");
            $printer -> text("-----------------------------------------------\n");
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Récu N°:". $paiement->number_paiement."\n");
            $printer -> text("Nom élève:". $paiement->student->name."\n");
            $printer -> text("Classe:". $paiement->student->classe->name."/". $paiement->student->classe->option->name."\n");
            $printer -> text("Motif: Paiment frais ". $paiement->cost->name."\n");
            $printer -> text("Date:". $paiement->created_at->format('d-m-Y')."\n");
            $printer -> text("-----------------------------------------------\n");
            /* Information for the receipt */
                $items = array(
                    new item( $paiement->cost->name,number_format($paiement->cost->amount*2000,1,',',' ')),
                );
                $total = new item('Total', number_format($paiement->cost->amount*2000,1,',',' '), true);
                $date=date('d/m/Y');


                /* Title of receipt */
            $printer -> setEmphasis(true);
            $printer -> text("DETAIL PIAMENT\n");
            $printer -> setEmphasis(false);

            /* Items */
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> setEmphasis(true);
            $printer -> text(new item('', 'CDF'));
            $printer -> setEmphasis(false);
            foreach ($items as $item) {
                $printer -> text($item);
            }
            $printer -> setEmphasis(true);
            $printer -> setEmphasis(false);
            $printer -> feed();

            /* Tax and total */
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text($total);
            $printer -> selectPrintMode();

            /* Footer */
            $printer -> feed(2);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Merci pour votre confiance\n");
            $printer -> text("L'education de votre enfant est notre priorité\n");
            $printer -> feed(2);
            $printer -> text($date . "\n");
            $printer -> text("\n");
            $printer -> cut();
            $printer -> close();

    } catch (\Exception $th) {
            dd($th->getMessage());
    }
    }
    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->where('scolary_year_id',$this->defaultScolaryYer->id)
                    ->whereDate('inscriptions.created_at',$this->date_to_search)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
        return view('livewire.paiment.inscription-paiment-page',['inscriptions'=>$inscriptions]);
    }
}

class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? ' ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
