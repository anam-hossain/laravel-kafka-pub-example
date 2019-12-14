<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'make' => 'required',
            'model' => 'required'
        ]);

        Inventory::create($request->only(['make', 'model']));

        return response()->json(['Inventory inserted successfully']);
    }
}
