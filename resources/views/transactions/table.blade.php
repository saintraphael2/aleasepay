@if(!empty($transactions))
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>reference Transaction</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Action</th>
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
                        <td> <a class="btn btn-primary" href="{{route('transaction.quittance', ['transaction' => $transaction['referenceTransaction']])}}" target="_blank">
                            Quittance PDF </a> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune transaction trouvée.</p>
    @endif

    