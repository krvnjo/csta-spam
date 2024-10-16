@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Sorry, something went wrong on the server. Please try again later.'))
