@if(!empty(session('success')))
<div class="alert alert-success text-lowercase" role="alert">
  {{ session('success') }}
</div>
@endif

@if(!empty(session('error')))
<div class="alert alert-danger text-lowercase" role="alert">
  {{ session('error') }}
</div>
@endif


@if(!empty(session('payment-error')))
<div class="alert alert-error text-lowercase" role="alert">
{{ session('payment-error') }}
</div>
@endif


@if(!empty(session('warning')))
<div class="alert alert-warning text-lowercase" role="alert">
{{ session('warning') }}
</div>
@endif


@if(!empty(session('info')))
<div class="alert alert-info text-lowercase" role="alert">
  {{ session('info') }}
</div>
@endif

@if(!empty(session('secondary')))
<div class="alert alert-secondary text-lowercase" role="alert">
  {{ session('secondary') }}
</div>
@endif