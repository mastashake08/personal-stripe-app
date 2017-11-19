@extends('layouts.app')

@section('content')
<charge vapid-key="{{env('VAPID_PUBLIC_KEY')}}"></charge>
@endsection
