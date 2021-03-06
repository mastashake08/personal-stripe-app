<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Jyrone Parker Payments</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div class="content">
                <div class="title m-b-md">
                    Jyrone Parker Payments
                </div>

                <div class="links">

                <form action="/api/charge" method="POST">
                  {{csrf_field()}}
                  <input type="hidden" value="{{$invoice->id}}" name="invoice_id"/>
                <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{env('STRIPE_KEY')}}"
                data-amount= {{$invoice->amount * 100}}
                data-name="Jyrone Parker Invoice"
                data-description="IT Services"
                data-image="https://s3.amazonaws.com/stripe-uploads/acct_15vDa4BVrwEbLrDTmerchant-icon-1496171148142-photo.jpg"
                data-locale="auto">
                </script>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
