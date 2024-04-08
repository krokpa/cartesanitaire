<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    
    public function index(Request $request)
    {

        $fiche_maladie = DB::table('fiche_observation_maladies')
        ->join('producteur', 'producteur.id_producteur', '=', 'fiche_observation_maladies.id_producteur')
        ->join('cooperative', 'cooperative.id_cooperative', '=', 'fiche_observation_maladies.id_cooperative')
        ->join('regions', 'regions.idregion', '=', 'fiche_observation_maladies.id_region')
        ->get()->toArray();

        foreach ($fiche_maladie as $key => $value) {

           $value->datatype = "maladie";

           $value->keyid = uniqid();
           
           $value->releve = DB::table('releve_maladies_plant')
           ->join('disease', 'releve_maladies_plant.id_maladie', '=', 'disease.DSE_Id')
           ->where('id_fiche_releve_parasitaire',$value->id_fiche_maladie)->get()->toArray();
           //$value->releve = array_values(group_by_object('numero_plant',$releves));
           
           $value->semis = DB::table('fiche_maladies_type_semis')
                            ->join('type_semis', 'type_semis.id_type_semis', '=', 'fiche_maladies_type_semis.id_type_semis')
                            ->where('fiche_maladies_type_semis.id_fiche_maladie',$value->id_fiche_maladie)
                            ->select("libelle")
                            ->get()
                            ->pluck('libelle')
                            ->toArray();
        }

        $fiche_insecte = DB::table('fiche_observation_insectes')
        ->join('producteur', 'producteur.id_producteur', '=', 'fiche_observation_insectes.id_producteur')
        ->join('cooperative', 'cooperative.id_cooperative', '=', 'fiche_observation_insectes.id_cooperative')
        ->join('regions', 'regions.idregion', '=', 'fiche_observation_insectes.id_region')
        ->get()->toArray();

        foreach ($fiche_insecte as $key => $value) {

           $value->datatype = "insecte";

           $value->keyid = uniqid();

           $value->releve = DB::table('releve_insectes_plant')
           ->join('insectes', 'releve_insectes_plant.id_insecte', '=', 'insectes.INSCT_Id')
           ->where('id_fiche_observation',$value->id_fiche_observation_insectes)->get()->toArray();

           //$value->releve = array_values(group_by_object('numero_plant',$releves));
           
           $value->semis = DB::table('fiche_insectes_type_semis')
                            ->join('type_semis', 'type_semis.id_type_semis', '=', 'fiche_insectes_type_semis.id_type_semis')
                            ->where('id_fiche_insectes',$value->id_fiche_observation_insectes)
                            ->select("libelle")
                            ->get()
                            ->pluck('libelle')
                            ->toArray();
        }

        $finaldata = array_merge($fiche_maladie,$fiche_insecte);

        $data = ['finaldata'=>$finaldata];
        //dd($data);
        
        return view('map',$data);
        return view('index');
    }

}