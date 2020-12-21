@extends('errors::minimal')

@section('title', __('Sessão expirada'))
@section('code', '419')
@section('message', __('A página que você acessou está há muito tempo sem atualização e não é mais válida. Por favor, clique em voltar em seu navegador e atualize a página.'))
