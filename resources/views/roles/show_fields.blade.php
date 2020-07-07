<!-- Created Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $role->created_at->format('D d, M, Y h:i') }}</p>
</div>
<br>
<h3 class="text-center">Users that belongs to this role</h3>
@include('users.table')