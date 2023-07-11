@extends('layouts.mainlayout')

@section('title' , 'profile')

@section('content')
   
<div class="mt-5">
   <h2>Your Rent Log</h2>
   <x-rent-log-table :rentlog='$rent_logs' />
</div>

@endsection