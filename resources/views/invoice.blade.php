@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Send An Invoice</div>

                <div class="panel-body">
                    <form class="form" role="form" method="post">
                      {{csrf_field()}}
                      <div class="form-group">
                      <input type="email" name="email" class="form-control" />
                      </div>
                      <div class="form-group">
                      <input type="number" name="amount" class="form-control" />
                      </div>
                      <button class="btn btn-default" type="submit">Send Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
