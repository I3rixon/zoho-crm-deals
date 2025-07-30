<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ZohoFormController extends Controller
{
    public function index()
    {
        return Inertia::render('Zoho/Form');
    }

    public function store(Request $request)
    {
        // Валидация
        $data = $request->validate([
            'account_name' => 'required',
            'deal_name' => 'required',
        ]);

        // Здесь будет логика интеграции с Zoho API

        return back()->with('success', 'Данные отправлены');
    }
}
