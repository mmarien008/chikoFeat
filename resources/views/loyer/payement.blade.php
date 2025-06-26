
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Paiement loyer</h1>


</div>

<form action="{{route("loyer.save")}}" method="post">


  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Paiement du loyé</span></h5>
                    <div class="row">
                        
                            <div class="row">
                                <div class="col  ">
                                    <div class="fs-6">
                                        Nom complet :{{$valeurs[0]->nom}} {{$valeurs[0]->post_nom}} {{$valeurs[0]->prenom}} 
                                        <input type="text" name="nom" value="" style="display: none">
                                        
                                    </div>

                                    <input type="text" name="id_locataire" value="{{$valeurs[1][0]}}" style="display: none" >
                                    <input type="text" name="id_numNom" value="{{$valeurs[1][1]}}" style="display: none">
                                    <input type="text" name="type" value="{{$valeurs[1][2]}}" style="display: none">
                                    <input type="text" name="loyer" value="{{$valeurs[0]->loyer}}" style="display: none">
                                    
                                </div>
        
                                <div class="col ">
                                    <div class="fs-6">
                                        Type propriété : {{$valeurs[0]->type}}_{{$valeurs[0]->nom_type}} 
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
@csrf

                            <div class="row mt-3">
        
                                <div class="col  ">
                                    <div class="fs-6">
                                        Numero/Nom : {{$valeurs[0]->numero}}
                                    
                                    </div>
                                    
                                </div>

                                <div class="col  fs-6">
                                    Le loyé est fixé à  

                                    <strong>{{$valeurs[0]->loyer}}$</strong>
                                        
                                </div>
        
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <input type="date" value="{{$valeurs[0]->date}}" class="form-control">
                                </div>
                            </div>

                            @if (is_null($valeurs[0]->date))
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Valider le paiment</button>
                                </div>
                                <div class="col">
                                    <div style="">

                                       
                                     

                                        @if (($valeurs[0]->montant % $valeurs[0]->loyer==0)==0)

                                            <div class="row">
                                                <div class="col"  value="0">
                                                    <input type="text" id="status_payement" name="status_payement" value="0" style="display: none">
                                                <span style="color: red"> Garantie actuelle :{{$valeurs[0]->montant}}$</span> 
                                                    <span id="value">pas de retrait sur garantie</span>
                                                </div>
                                                <div class="col">
                                                    <input type="checkbox" id="retrait"
                                                    class="form-check"  type="retrait" name="check">
                                                </div>

                                            </div>
                                            
                                        @elseif(($valeurs[0]->montant % $valeurs[0]->loyer==0)!=0)

                                        <p style="color: red;">la garantie est trop inferieure pour soustraire le loyer , merci</p>

                                        @endif
                                        
                          
                                        
                                        
                                    </div>
                                    
                                </div>

                                <div class="col">
                                    <input type="number" name="montant_loyer"  class="form-control"  max="{{$valeurs[0]->loyer-1}}" min="2" value="" placeholder="Payez une partie du loyé">
                                </div>
            
                            </div>
                                
                            @else

                                <p style="color: red;" class="mt-3">pour ce mois rien à signaler </p>
                                
                            @endif
        
                        

                        </div>
                    </div>
            </div>

        </div>



 

    </div>
  </section>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

$(document).ready(function() {
    $("#retrait").on("click", function() {
        if ($(this).is(":checked")) {
           
            $("#value").text("retrait sur garantie");
            $("#status_payement").val("1")

        } else {
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0")
           
        }
    });
});



  </script>
@endsection


