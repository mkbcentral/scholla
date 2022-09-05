<?php

namespace App\Http\Livewire\Paiment;

use App\Http\Livewire\Helpers\item;
use App\Models\AppSetting;
use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class CostPaimentPage extends Component

    {
        public $selectedIndex=0;
        public $classes,$classe_id=0,$cost_id=0;
        public $keySearch='';
        public $state=[],$costs=[];
        public $defaultScolaryYer,$options=[];
        public $month_name='',$months=[],$currentMonth,$inscription,$isc_id=0;
        public $paiments=[];
        public  $taux=2000;
        public $month_select='',$cost_select=0;

        public function mount()
        {
            $defualtOption=ClasseOption::where('name','Primaire')->first();
            $this->selectedIndex=$defualtOption->id;

            $this->costs=CostGeneral::orderBy('name','ASC')->where('active',true)->get();
            $this->option=$defualtOption;

            setlocale(LC_TIME, "fr_FR");
            $this->currentMonth=date('m');
            $this->month=$this->currentMonth;
            foreach (range(1,12) as $m) {
                $this->months[]=date('m',mktime(0,0,0,$m,1));
            }
        }
        public function changeIndex(ClasseOption $option){
            $this->selectedIndex=$option->id;
        }


        public function show(Inscription $inscription){
            $this->inscription=$inscription;
            $this->isc_id=$inscription->id;
        }

        public function generateNumberPaiement(){
            $number=0;
            if($this->option->name=='Primaire'){
                $number=rand(99,1000).'-P';
            }else if($this->option->name=='Maternelle'){
                $number=rand(99,1000).'-M';
            }else{
                $number=rand(99,1000).'-S';
            }
            return $number;
        }

        public function validatePaiement(){
            $paiement=new Paiment();
            $paiement->scolary_year_id=$this->defaultScolaryYer->id;
            $paiement->cost_general_id=$this->cost_id;
            $paiement->student_id=$this->inscription->student->id;
            $paiement->classe_id=$this->inscription->student->classe->id;
            $paiement->mounth_name=$this->month_name;
            $paiement->number_paiement=$this->generateNumberPaiement();
            $paiement->user_id=auth()->user()->id;
            $paiement->save();
            $this->testPrint($paiement);

            $this->dispatchBrowserEvent('data-added',['message'=>"Paiment bien validé !"]);

        }

        public function getGetPaiementDay(){
            $this->paiments=Paiment::whereDate('created_at',date('Y-m-d'))
                            ->with('student.classe.option')
                            ->get();
        }
    public function testPrint(Paiment $paiement){

        $setting=AppSetting::find(1);
            try {
                $connector = new WindowsPrintConnector($setting->printer_name);
                //FilePrintConnector("php://stdout");
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
                $printer -> text("Motif: Paiment frais". $paiement->cost->name."\n");
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

    public function annulerPaiement(Paiment $paiement){
        $paiement->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Paiement annulé !"]);
    }

    public function render()
    {

        $this->classes=Classe::orderBy('name','ASC')
            ->where('classe_option_id',$this->selectedIndex)
            ->with('option')
            ->get();
        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
            $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$this->classe_id)
                        ->where('scolary_year_id',$this->defaultScolaryYer->id)
                        ->where('students.name','Like','%'.$this->keySearch.'%')
                        ->orderBy('students.name','ASC')
                        ->where('inscriptions.active',true)
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
        return view('livewire.paiment.cost-paiment-page',['inscriptions'=>$inscriptions]);
    }
}
