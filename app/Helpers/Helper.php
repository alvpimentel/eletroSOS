<?php

if (!function_exists('formatarDataHora')) {
    function formatarDataHora($data)
    {
        return \Carbon\Carbon::parse($data)->format('d/m/Y H:i');
    }
}

if (!function_exists('formatarData')) {
    function formatarData($data)
    {
        return \Carbon\Carbon::parse($data)->format('d/m/Y');
    }
}

if (!function_exists('previousUrl')) {
    function previousUrl()
    {
        if (!session()->has('previous_url')) {
            session()->put('previous_url', url()->previous());
        }
        return session('previous_url', url('/')); 
    }
}
