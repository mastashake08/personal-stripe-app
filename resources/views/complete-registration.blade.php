@extends('layouts.stripe')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Complete Registration</div>

                <div class="panel-body">
                    <form class="form" role="form" method="post" action="{{url('/complete-registration')}}">
                      <input type="hidden" value="{{$customer_id}}" name="customer_id">
                      <input type="hidden" value="{{$plan_id}}" name="plan_id">
                      {{csrf_field()}}
                      <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Email You Wish To Create"/>
                      </div>
                      <div class="form-group">
                      <input type="password" name="password" class="form-control" placeholder="New Email Password"/>
                      </div>
                      <script
                      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                      data-key="{{env('STRIPE_KEY')}}"
                      data-amount= 299
                      data-name="Jyrone Parker Web Hosting"
                      data-description="Web Hosting"
                      data-image="https://s3.amazonaws.com/stripe-uploads/acct_15vDa4BVrwEbLrDTmerchant-icon-1496171148142-photo.jpg"
                      data-locale="auto">
                      </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
