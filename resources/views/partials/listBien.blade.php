@foreach ($mes_biens['pour_immeubles'] ?? [] as $propriete)
<tr>
    <td><strong>Immeuble</strong>: {{$propriete->nom_immeuble}}</td>
    <td><strong>Appartement:</strong> {{$propriete->numero}}</td>
    <td>{{$propriete->date_debut}}</td>
    <td>
        <span class="badge text-bg-danger">
            <a href="{{ route('loyer.payer', ['nom_locataire'=>$propriete->id_locataire, 'type_bien'=>$propriete->id_immeuble, 'numero'=>$propriete->id_appartement, 'type'=>'1']) }}" style="color:aliceblue; text-decoration:none;">Payer</a>
        </span>
    </td>
    <td>
        <span class="badge text-bg-danger">
            <a href="{{ route('garantie.show', ['id_locataire'=>$propriete->id_locataire, 'id_type_bien'=>$propriete->id_immeuble, 'id_bien'=>$propriete->id_appartement, 'type'=>'1']) }}" style="color:aliceblue; text-decoration:none;">Ajout ou retrait</a>
        </span>
    </td>
</tr>
@endforeach

@foreach ($mes_biens['pour_galerie'] ?? [] as $propriete)
<tr>
    <td><strong>Galerie</strong>: {{$propriete->nom_galerie}}</td>
    <td><strong>Nom:</strong> {{$propriete->numero}}</td>
    <td>{{$propriete->date_debut}}</td>
    <td>
        <span class="badge text-bg-danger">
            <a href="{{ route('loyer.payer', ['nom_locataire'=>$propriete->id_locataire, 'type_bien'=>$propriete->id_galerie, 'numero'=>$propriete->id_autre_bien, 'type'=>'2']) }}" style="color:aliceblue; text-decoration:none;">Payer</a>
        </span>
    </td>
    <td>
        <span class="badge text-bg-danger">
            <a href="{{ route('garantie.show', ['id_locataire'=>$propriete->id_locataire, 'id_type_bien'=>$propriete->id_galerie, 'id_bien'=>$propriete->id_autre_bien, 'type'=>'2']) }}" style="color:aliceblue; text-decoration:none;">Ajout ou retrait</a>
        </span>
    </td>
</tr>
@endforeach
