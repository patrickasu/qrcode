@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Account: {{ $account->id }}
            <small>
                 @if ($account->applied_for_payout == 1)
                    Payout Request Pending
                @endif
            </small>
        </h1>
        <h1 class="pull-right" style="margin-bottom: 10px;">
        @if (Auth::user()->id == $account->user_id && $account->applied_for_payout != 1)
            {!! Form::open(['route' => ['accounts.apply_for_payout'], 'method' => 'post', 'class'=>'pull-left']) !!}
                <input type="hidden" value="{{ $account->id }}" name="apply_for_payout" />
                {!! Form::button('<span class="glyphicon glyphicon-credit-card"></span> Apply for Payout', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Are you sure yoy want to apply for Payout?')"]) !!}  
            {!! Form::close() !!}    
        @endif
        @if (Auth::user()->role_id < 3 && $account->paid != 1)
            {!! Form::open(['route' => ['accounts.mark_as_paid'], 'method' => 'post', 'class'=>'pull-left', 'style'=>'margin-left: 20px;']) !!}
                <input type="hidden" value="{{ $account->id }}" name="mark_as_paid" />
                {!! Form::button('<span class="glyphicon glyphicon-credit-card"></span> Mark as Paid', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Are you sure you want to confirm Payout?')"]) !!}  
            {!! Form::close() !!}  
        @endif
        </h1>
    </section>
    <div class="content">
    <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                    {{-- <a href="{{ route('accounts.index') }}" class="btn btn-default">Back</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
