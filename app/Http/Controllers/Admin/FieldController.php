<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index() {
        return view('admin.fields.index');
    }
    public function create() {
        return view('admin.fields.create');
    }
    public function store(Request $request) {
        
    }
    public function show($id) {
        
    }
    public function edit($id) {
        return view('admin.fields.edit');
    }
    public function update(Request $request, $id) {

    }
    public function destroy($id) {

    }
}