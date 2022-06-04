<?php

namespace App\Modules\ParserResults\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\ParserResults\Models\ParserResult;


class ParserResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return ParserResult::with('parser')->findOrFail($id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        ParserResult::findOrFail($id)->delete();
    }
}
