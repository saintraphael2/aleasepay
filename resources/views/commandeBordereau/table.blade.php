<div class="row input-daterange">

<div class="form-group col-sm-2">
<a  href="{{ route('commandeBordereau.form') }}" type="submit"  id="commander" class="btn btn-primary btnSubmit">Commander</a>
</div>
</div>
@if(!empty($bordereaux))

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Compte</th>
                    <th>Type Bordereau</th>
                    <th>Date de commande</th>
                    <th>Quantité</th>
                    <th>numéro Ordre</th>
                    <th>Etat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bordereaux as $bordereau)
                    <tr>
                        <td>{{ $bordereau['compte']}}</td>
                        <td>{{ $bordereau['libelleBordereau'] }}</td>
                        <td>{{ $bordereau['dateCommande'] }}</td>
                        <td>{{ $bordereau['quantite'] }}  </td>
                        <td>{{ $bordereau['numeroOrdre']}} </td>
                        <td>
                        @if($bordereau['etat'] == '0')
                            <a>
                                En attente
                            </a>
                            <!-- <button class="btn btn-secondary" >Paiement </button> -->
                        @elseif($bordereau['etat'] == '1')
                            En cours
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun bordereau trouvé.</p>
    @endif

    