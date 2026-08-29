<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function servicos()
    {
        return view('servicos');
    }

    public function planos()
    {
        return view('planos');
    }

    public function faq()
    {
        return view('faq');
    }

    public function particular()
    {
        return view('planos.particular');
    }

    public function familiar()
    {
        return view('planos.familiar');
    }

    public function corporativo()
    {
        return view('planos.corporativo');
    }
}
