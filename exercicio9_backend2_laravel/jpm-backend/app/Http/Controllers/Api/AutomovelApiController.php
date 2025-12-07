<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutomovelRequest;
use App\Http\Resources\AutomovelResource;
use App\Models\Automovel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class AutomovelApiController extends Controller
{
    public function index()
    {
        $autos = Automovel::with('motorista.usuario')->paginate(10);
        return AutomovelResource::collection($autos);
    }

    public function show($id)
    {
        $auto = Automovel::with('motorista.usuario')->findOrFail($id);
        return new AutomovelResource($auto);
    }

    public function store(AutomovelRequest $req)
    {
        try {
            $auto = Automovel::create($req->validated());

            return (new AutomovelResource(
                $auto->loadMissing('motorista.usuario')
            ))->response()->setStatusCode(201);

        } catch (QueryException $e) {
            if ($e->getCode()==='23000') {
                return response()->json(['error'=>'Placa já cadastrada'],422);
            }
            throw $e;
        }
    }

    public function update(AutomovelRequest $req, $id)
    {
        $auto = Automovel::findOrFail($id);
        $auto->update($req->validated());
        return new AutomovelResource($auto->loadMissing('motorista.usuario'));
    }

    public function destroy($id)
    {
        Automovel::findOrFail($id)->delete();
        return response()->json(['message'=>'Automóvel removido']);
    }
}