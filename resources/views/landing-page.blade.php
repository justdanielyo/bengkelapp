@extends('templates.app', ['title' => 'Landing || Bengkel'])
<!-- extends : memanggil file blade biasanya untuk template, pemanggillanya : folder.file -->

@section('content-dinamis')
    <!-- section : mengisi html ke yield yang ada di file extends -->
    {{-- Auth : class yang menyimpan data riwayat login --}}
    {{-- user() : nama table (users) --}}
    {{-- name : migration --}}
    <h1 class="mt-3 text-center">Selamat Datang, {{ auth()->user()->name }}</h1>
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
@endSection
