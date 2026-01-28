<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Показывает страницу контактов
     */
    public function index()
    {
        // передаём services для меню и формы
        $services = Service::all();

        return view('contacts', compact('services'));
    }
}
