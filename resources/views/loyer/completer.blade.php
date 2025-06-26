
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Paiement loyer</h1>


</div>

<form action="{{route('loyer.completerSave')}}" method="post">



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
                                        Nom complet : {{$infoComplete[0]->nom}}
                                      
                                    </div>

                                    <input type="text" name="id_type_propriete" value="{{$infoComplete[0]->type}}" style="display: none" >
                                    <input type="text" name="id_propriete" value="{{$infoComplete[0]->id}}" style="display: none">
                                    <input type="text" name="loye_fixer" value="{{$infoComplete[0]->loyer}}" style="display: none">

                                    <input type="text" name="loyer_payer_existant" value="{{$infoComplete[0]->montant}}" style="display: none">
                                   
                                    <input type="text" name="date" value="{{$infoComplete[1]}}" style="display: none">
                                    
                                </div>
        
                                <div class="col ">
                                    <div class="fs-6">
                                        Type propriété : 
                                        
                                    </div>
                                </div>
                                
                            </div>
@csrf

                            <div class="row mt-3">
        
                                <div class="col  ">
                                    <div class="fs-6">
                                        Numero/Nom : {{$infoComplete[0]->numero}}
                                    
                                    </div>
                                    
                                </div>

                                <div class="col  fs-6">
                                    Le loyé est fixé à  

                                    <strong>{{$infoComplete[0]->loyer}}$</strong> et vous avez payé <strong style="color: red;"> {{$infoComplete[0]->montant}}$</strong>
                                        
                                </div>
        
                            </div>
        
                        
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Completer le loyé</button>
                                </div>
                                <div class="col">
                                    <input type="number" name="montant_loyer"  class="form-control"  max="{{$infoComplete[0]->loyer -$infoComplete[0]->montant}}" min="0" value="" placeholder="Completer votre loyer">
                                </div>
                                
                            </div>
                        </div>
                    </div>
            </div>

        </div>



 

    </div>
  </section>
</form>
  <script>



  </script>
@endsection


