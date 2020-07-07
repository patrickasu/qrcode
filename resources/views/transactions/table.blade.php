<div class="table-responsive">
    <table class="table" id="transactions-table">
        <thead>
            <tr>      
                <th>Qrcode</th>
                <th>Buyer</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
            <td><a href="{{ route('transactions.show', [$transaction->id]) }}">{{ $transaction->qrcode['product_name'] }}</a><span class="text-light"> | {{ $transaction->created_at->format('D d, M Y h:i') }}</span></td>
            <td>{{ $transaction->user['name'] }}</td>
            <td>{{ $transaction->payment_method }}</td>
            <td>₦{{ number_format($transaction->amount) }}</td>
            <td>{{ $transaction->status }} <br/> <span class="text-light"></span></td>
                <td>
                    {{-- {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        <a href="{{ route('transactions.show', [$transaction->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {{-- <a href="{{ route('transactions.edit', [$transaction->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div> --}}
                    {{-- {!! Form::close() !!} --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
