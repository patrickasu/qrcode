<div class="table-responsive">
    <table class="table" id="accounts-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Balance</th>
                <th>Total Credit</th>
                <th>Total Debit</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accounts as $account)
            <tr>
                <td><a href="{{ route('accounts.show', [$account->id]) }}">{{ $account->user['email'] }}</a></td>
                <td>${{ number_format($account->balance) }}</td>
                <td>${{ number_format($account->total_credit) }}</td>
                <td>${{ number_format($account->total_debit) }}</td>
                <td>
                    @if ($account->applied_for_payout == 1)
                        Payment Pending
                        @elseif($account->paid == 1)
                        <i class="fa fa-check-square text-green" style="font-size:16px;"></i> Paid
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['accounts.destroy', $account->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accounts.show', [$account->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('accounts.edit', [$account->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {{-- {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
