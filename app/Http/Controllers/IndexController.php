<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    
    public function index(Request $request)
    {

        $localites = DB::table('localite')->get()->toArray();

        foreach ($localites as $key => $localite) {

            $fiche_maladie = DB::table('fiche_observation_maladies')
            ->join('producteur', 'producteur.id_producteur', '=', 'fiche_observation_maladies.id_producteur')
            ->join('cooperative', 'cooperative.id_cooperative', '=', 'fiche_observation_maladies.id_cooperative')
            ->join('regions', 'regions.idregion', '=', 'fiche_observation_maladies.id_region')
            ->where('idlocalite',$localite->idlocalite)
            ->first();

            $fiche_maladie->datatype = "maladie";

            $fiche_maladie->keyid = uniqid();
            
            $fiche_maladie->releve = DB::table('releve_maladies_plant')
            ->join('disease', 'releve_maladies_plant.id_maladie', '=', 'disease.DSE_Id')
            ->where('id_fiche_releve_parasitaire',$fiche_maladie->id_fiche_maladie)->get()->toArray();
            //$value->releve = array_values(group_by_object('numero_plant',$releves));
            
            $fiche_maladie->semis = DB::table('fiche_maladies_type_semis')
                                ->join('type_semis', 'type_semis.id_type_semis', '=', 'fiche_maladies_type_semis.id_type_semis')
                                ->where('fiche_maladies_type_semis.id_fiche_maladie',$fiche_maladie->id_fiche_maladie)
                                ->select("libelle")
                                ->get()
                                ->pluck('libelle')
                                ->toArray();

            $localite->fichemaladie = $fiche_maladie;

            $fiche_insecte = DB::table('fiche_observation_insectes')
            ->join('producteur', 'producteur.id_producteur', '=', 'fiche_observation_insectes.id_producteur')
            ->join('cooperative', 'cooperative.id_cooperative', '=', 'fiche_observation_insectes.id_cooperative')
            ->join('regions', 'regions.idregion', '=', 'fiche_observation_insectes.id_region')
            ->where('idlocalite',$localite->idlocalite)
            ->first();

                $fiche_insecte->datatype = "insecte";

                $fiche_insecte->keyid = uniqid();

                $fiche_insecte->releve = DB::table('releve_insectes_plant')
                ->join('insectes', 'releve_insectes_plant.id_insecte', '=', 'insectes.INSCT_Id')
                ->where('id_fiche_observation',$fiche_insecte->id_fiche_observation_insectes)->get()->toArray();

                //$fiche_insecte->releve = array_fiche_insectes(group_by_object('numero_plant',$releves));
                
                $fiche_insecte->semis = DB::table('fiche_insectes_type_semis')
                                    ->join('type_semis', 'type_semis.id_type_semis', '=', 'fiche_insectes_type_semis.id_type_semis')
                                    ->where('id_fiche_insectes',$fiche_insecte->id_fiche_observation_insectes)
                                    ->select("libelle")
                                    ->get()
                                    ->pluck('libelle')
                                    ->toArray();
            

                $localite->ficheinsecte = $fiche_insecte;
            
            
        }

        dd($localites);

         $data = ['localites'=>$localites];
        
        return view('map',$data);
        return view('index');
    }

}