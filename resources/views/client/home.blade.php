@if(count($user->pets)<1)
    <div class="alert alert-danger" role="alert">
        You need to setup at least one pet.
    </div>
@endif


<div class="row">
    <div class="col-md-8">
        <booking-component :user="{{$user}}" scope="today"></booking-component>
        <booking-component :user="{{$user}}" scope="future"></booking-component>
    </div>

    <div class="col-md-4">
        <client-pets title="Your Pets"></client-pets>
        <make-a-payment payee="{{config('dogwalker.paypal_payee')}}"></make-a-payment>
    </div>
</div>

