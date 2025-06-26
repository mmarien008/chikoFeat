<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Loyer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0px;
        }
        .pagetitle {
            text-align: center;
            margin-bottom: 20px;
        }
        .pagetitle h1 {
            margin: 5px 0;
            color: #333;
        }
        .content {
        
        
            width: 100%;
            overflow-x: auto; /* Pour la responsivité */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
       
        thead th {
            padding: 10px;
            font-size: 14px;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }


        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        tbody tr:hover {
            background-color: #e0f7fa;
        }
        td, th {
            text-align: center;
            padding: 8px;
            font-size: 13px;
            border: 1px solid black;
        }
        td {
            color: #333;
        }
        .status-payed {
            color: #28a745;
            font-weight: bold;
        }
        .status-unpayed {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
  @php
     $observation = "";
     $statut = "";
     $montant = "";
     $num = 0;

     
  @endphp
  
  <div class="pagetitle">
   

  </div>

  <div class="content"> 


            <div style="text-align: center; width: 100%;  ">
                
               

                <div style="text-align: center;  display:inline-block; margin-bottom:10px;">
                    <h2 >

                        IMMEUBLE  TCHIKO - HOUSE
                         
                    </h2>
                   
                   
                   
                    <div>TEL : +(243) 816000266/997312581</div>
                    <div> {{ $valeur["input"][0]->adresse }}  </div>
                    <div style="text-decoration: underline"> {{ strtoupper($valeur["input"][0]->ville) }} </div>
                </div>
               
            
            </div>
            <hr>
           
      <table>
          <thead>
            <tr>
                <td style="color: blue; font-size:18px" colspan="  @if ($valeur["message"]=="immeuble") {{12}}  @elseif($valeur["message"]=="galerie"){{14}} @endif">
                    {{ strtoupper('Rapport loyer') }}

                     {{strtoupper( \Carbon\Carbon::parse($valeur["date"])->translatedFormat('F Y')) }} 

                     @if ($valeur["message"]=="immeuble")
                     Immeuble {{ strtoupper( $valeur["input"][0]->nom_bien) }}
                         
                     @else

                     Galeries {{ strtoupper( $valeur["input"][0]->nom_bien) }}
                         
                     @endif
                     
                     

                    




                </td>
            </tr>
              <tr>
                <th>Num</th>
                <th>Occupant</th>
             
                @if ($valeur["message"]=="immeuble")
                <th>Numéro Apparts</th>
                @elseif($valeur["message"]=="galerie")
                <th>Magasin</th>
                <th>Depot</th>
                <th>Etalage</th>
  
                @endif

                <th>Garantie recu </th>
                <th>ajout sur garantie</th>
                <th>retrait sur garantie</th>
             
                <th>solde garantie</th>

              

                   
                  
                  
                  <th>Montant</th>
                  <th>Statut</th>
                  <th>Date du Paiement</th>
           
                  <th>Observation</th>
              </tr>
              <tr>
                <td style="background-color: rgb(76, 76, 198) " colspan="  @if ($valeur["message"]=="immeuble") {{12}}  @elseif($valeur["message"]=="galerie"){{14}} @endif">
                  
                </td>
            </tr>
          </thead>
          <tbody>
         
              @if (isset($valeur))

                  @for ($i = 0; $i < count($valeur["input"]); $i++)

                
                      @php
                       $num= $num+1;

                      if($valeur["input"][$i]->montant==""){
                          $montant="";
                      }else{
                        $montant=$valeur["input"][$i]->montant."$";

                      }
                      if($valeur["input"][$i]->statut_loyer==1){
                        $statut="solde";
                      }else if($valeur["input"][$i]->statut_loyer==0){
                        $statut="Non payé";
                      }else{
                         $statut="Avance";

                      }
                          $observation = "";
                          if(isset($valeur["dif"][$i])){
                            if (count($valeur["dif"][$i]) > 0) {
                              for ($j = 0; $j < count($valeur["dif"][$i]); $j++) { 
                                  $observation .= \Carbon\Carbon::parse($valeur["dif"][$i][$j])->translatedFormat('F Y')   . ",";
                              }
                              $observation = "NP " . $observation;
                          }
                          }

                          
                      
                      @endphp
                      <tr>
                        <td>{{ $num }} </td>
                        
                        
                          <td>{{ $valeur["input"][$i]->nom }} {{ $valeur["input"][$i]->post_nom }} {{ $valeur["input"][$i]->prenom }}</td>

                          @if($valeur["message"]=="galerie")
                         
                          <td>@if ($valeur["input"][$i]->type=="Magasin") {{ $valeur["input"][$i]->numero }}   @else ....... @endif</td>
                          <td>@if ($valeur["input"][$i]->type=="Depot") {{ $valeur["input"][$i]->numero }} @else ....... @endif</td>
                          <td>@if ($valeur["input"][$i]->type=="Etalage") {{ $valeur["input"][$i]->numero }} @else ....... @endif</td>

                          @elseif ($valeur["message"]=="immeuble")
                          <td>{{ $valeur["input"][$i]->numero }}</td>

                          @endif

                       

                          <td>{{ $valeur["input"][$i]->montant_initiale }} $</td>
                          <td>{{ $valeur["input"][$i]->montant_ajouter }} $</td>
                          <td>{{ $valeur["input"][$i]->montant_retirer }} $</td>
                          <td>{{ $valeur["input"][$i]->solde_garantie }} $</td>
                         
                          


                          <td>{{ $montant }} </td>

                          <td class="">
                              {{ $statut }}
                          </td>

                          <td>{{ $valeur["input"][$i]->date }}</td>
                       
                         
                          <td>{{ $observation }}  @if ($valeur["input"][$i]->date_fin!=null)
                            {{ " a quitter le ".$valeur["input"][$i]->date_fin }}
                              
                          @endif </td>
                      </tr>
                  @endfor
              @else
                  <tr>
                      <td colspan="7">Aucune donnée disponible</td>
                  </tr>
              @endif
          </tbody>
      </table>
  </div>
</body>
</html>
