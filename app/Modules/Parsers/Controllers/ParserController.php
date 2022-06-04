<?php

namespace App\Modules\Parsers\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Parsers\Models\Parser;
use App\Modules\Parsers\Requests\ParserRequest;
use App\Utils\ParserUtil;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Parser::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParserRequest $request)
    {
        $parser = Parser::create([
            'name' => $request['name'],
            'url' => $request['url'],
            'selector' => $request['selector'],
            'search_link_selector' => $request['search_link_selector'],
            'targets' => $request['targets'],
            'img_selector' => $request['img_selector'],
            'internal_link_selector' => $request['internal_link_selector'],
        ]);

        return ['parser' => $parser,
            'message' => "Парсер {$parser->name} успешно добавлен"];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Parser::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParserRequest $request, $id)
    {
        $parser = Parser::findOrFail($id);
        $parser->fill($request->all())->save();

        return ['parser' => $parser,
            'message' => "Парсер {$parser->name} успешно изменен"];
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
        Parser::findOrFail($id)->delete();
    }

    public function start($id)
    {
        $parser = Parser::findOrFail($id);
        $parserUtil = new ParserUtil($parser);
        $parserUtil->start();
        return ['message' => $parserUtil->saveResults()];
    }
}
