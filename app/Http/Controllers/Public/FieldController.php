<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function index(){
        return view('public.fields.index');
    }

    public function show(Field $field){
        return view('public.fields.show', compact('field'));
    }
}
