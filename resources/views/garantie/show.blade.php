
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Paiement garantie</h1>


</div>

<form action="{{route('garantie.save')}}" method="post">


  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Paiement du Garantie</span></h5>
                    <div class="row">
                        
                            <div class="row">
                                <div class="col  ">
                                    <div class="fs-6">
                                        Nom complet : {{{$val->nom}}} {{{$val->post_nom}}} {{{$val->prenom}}}
                                      
                                    </div>
                                </div>
        
                                <div class="col ">
                                    <div class="fs-6">
                                        Type propriété : {{{$val->type}}} {{{$val->nom_type}}}
                                        
                                    </div>
                                </div>
                                
                            </div>
@csrf

                            <input type="text" name="id_locataire" id="" value="{{$val->id}}" style="display: none">
                            <input type="text" name="id_bien" value="{{$val->id_bien}}" id="" style="display: none">
                            <input type="text" name="montant_initiale" value="{{$val->montant_initiale}}" id="" style="display: none">

                            <input type="text" name="type" value="@if ($val->type=="Immeuble")
                            {{1}}
                            @elseif($val->type=="Galerie")
                              {{2}}
                            @endif
                            
                            " id="" style="display: none">



                            <div class="row mt-3">
        
                                <div class="col  ">
                                    <div class="fs-6">
                                        Numero/Nom : {{{$val->numero}}}
                                    
                                    </div>
                                    
                                </div>

                                <div class="col  fs-6">
                                    garantie recu {{$val->montant_initiale}}

                                    <strong>$</strong> et solde garantie {{{$val->montant}}} <strong style="color: red;"> $</strong>
                                        
                                </div>
        
                            </div>

                            <div class="row">
                                <div class="col  fs-6" style="color: red;">
                                    La garantie est fixé à {{{$val->garantie}}} $
                                </div>
                            </div>
        
                        
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="number" name="montant_garantie" required  class="form-control"  max="{{}}" min="1" value="" placeholder="entrer le montant du garantie">
                                        </div>
                                        <div class="col">
                                          <select name="operation" class="form-control" id="operation">
                                            <option value="1">Ajout sur garantie</option>
                                            <option value="2">retrait sur garantie</option>


                                          </select>
                                        </div>
    
    
                                    </div>

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


