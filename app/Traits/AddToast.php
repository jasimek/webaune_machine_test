<?php
namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait AddToast
{
    protected function addToast( string $type,string $title, string $message)
    {
        $toast = [
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
        ];
 
        Session::flash('toast', $toast);
    }
}