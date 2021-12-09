@extends('layouts.app')

@section('js', 'account.js')

@section('content')
    <app-content :external_deal="{{ $data }}"></app-content>
@endsection
