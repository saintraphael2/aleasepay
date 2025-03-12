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
                    <th>Etat </th>
                </tr>
            </thead>
            <tbody>
                @foreach($bordereaux as $bordereau)
                    <tr>
                        <td>{{ $bordereau['compte']}}</td>
                        <td>{{ $bordereau['libelleBordereau'] }}</td>
                        <td>{{ $bordereau['dateCommande'] }}</td>
                        <td>{{ $bordereau['quantite'] }}  </td>
                        <td>{{ $bordereau['numeroOrdre']}}</td>
                        <td>
    @isset($bordereau['etat'])
        @switch($bordereau['etat'])
            @case('0')
                <a>En attente</a>
                @break
            @case('1')
                <a>En cours</a>
                @break
            @case('2')
                <a>Validé</a>
                @break
            @default
                <a>État inconnu</a>
        @endswitch
    @else
        <a>État non défini</a>
    @endisset
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun bordereau trouvé.</p>
    @endif

    