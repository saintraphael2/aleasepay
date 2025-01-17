@if(!empty($transactions))
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>reference Transaction</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction['referenceTransaction'] }}</td>
                        <td>{{ $transaction['contribuable'] }}</td>
                        <td>{{ $transaction['nif'] }}</td>
                        <td>{{ $transaction['transBankDate'] }}  </td>
                        <td>{{ number_format($transaction['mount'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune transaction trouvée.</p>
    @endif

    