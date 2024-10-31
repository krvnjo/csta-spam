@extends('errors::minimal')

@section('title', __('Unauthorized Action'))
@section('code', '403')
@section('message', __('Unauthorized action. You do not have the permission to access this.'))
