@if(!empty($cotisations))
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotisations as $cotisation)
                    <tr>
                        <td>{{ $cotisation['referenceID'] }}</td>
                        <td>{{ $cotisation['designation'] }}</td>
                        <td>{{ $cotisation['requester'] }}</td>
                        <td>{{ $cotisation['created_at'] }}</td>
                        <td>{{ number_format($cotisation['amount'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune cotisation trouvée.</p>
    @endif