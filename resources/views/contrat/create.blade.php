
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Mes biens</h1>
    <nav>
   
    </nav>
</div><!-- End Page Title -->

<form action="{{route("contrat.save")}}" method="post">
    @csrf

    <section class="section dashboard">
        <div class="row">
    
            <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Etablir le contrat</span></h5>
        
    
                        <div class="row">
    
                            <div class="col  ">
                                <div class="fs-6">
                                    Nom complet : {{$donnee["locatair"][0]}}
                                    <input type="text" name="nom" value="{{$donnee["locatair"][1]}}" style="display: none">
                                </div>
                                
                            </div>
    
                            <div class="col ">
                                <div class="fs-6">
                                    Type de propriété : {{$donnee["monBien"][0]}}
                                    <input type="text" name="type" value="{{$donnee["monBien"][1]}}" style="display: none">
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="row mt-3">
    
                            <div class="col  ">
                                <div class="fs-6">
                                    Numero/Nom : {{$donnee["numeroAppart"][0]}}
                                    <input type="text" name="numnom" value="{{$donnee["numeroAppart"][1]}}" style="display: none">
                                    
                                </div>
                                
                            </div>
    
                            <div class="col ">
                                <div class="fs-6">
                                    Nom de propriété : {{$donnee["immeuble"][0]}} 
                                    <input type="text" name="nomP" value="{{$donnee["immeuble"][1]}} " style="display: none">
                                </div>
                            </div>
    
                            
                        </div>
                        @if ($donnee["monBien"][0]=="Galerie")

                        <div class="row mt-3">
                            <div class="col">
                                <input type="text" required class="form-control" placeholder="Veillez un nom personalisé" name="nom_modifier_autre" style="">

                            </div>
                        </div>
                            
                        @else
                            
                        @endif


    
                        <div class="row mt-3">
    
                            <div class="col d-flex justify-content-center align-items-center">
                                <input type="number" name="garantie" required id="inputPassword6" class="form-control " 
                                aria-describedby="passwordHelpInline" placeholder="Montant du garantie $">
                            </div>
    
                            <div class="col d-flex justify-content-center align-items-center">
                                <input type="number" name="loyer" required id="inputPassword6" class="form-control " 
                                aria-describedby="passwordHelpInline" placeholder="Montant du loyer">
                            </div>
    
                
                        </div>
                        <div class="row mt-3">
                            <button type="submit" class="btn btn-primary">Valider le contrat</button>
                        </div>
                </div>
    
            </div>
    
    
    
              
    
            </div>
          </div><!-- End Left side columns -->
    
         
     
    
        </div>
      </section>

</form>
 
@endsection


