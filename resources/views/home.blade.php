@extends('layouts.app')

@section('content')
<charge vapidKey="{{env('VAPID_PUBLIC_KEY')}}"></charge>
@endsection
