<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DenunciaRequest;
use App\Http\Requests\DenunciaStatusRequest;   // ← NOVO
use App\Http\Resources\DenunciaResource;
use App\Models\Denuncia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Exception;

class DenunciasApiController extends Controller
{
    public function __construct()
    {
        // remove o envelope “data” do resource
        DenunciaResource::withoutWrapping();
    }

    public function index(): JsonResponse
    {
        $denuncias = Denuncia::with([
            'denunciantes',
            'denunciado',
            'administrador',
            'viagem',
        ])->get();

        return response()->json(
            DenunciaResource::collection($denuncias)
        );
    }

    public function show($id = null): JsonResponse
    {
        if (empty($id)) {
            return response()->json(['message' => 'ID da denúncia não informado'], 400);
        }

        try {
            $den = Denuncia::with([
                'denunciantes',
                'denunciado',
                'administrador',
                'viagem',
            ])->findOrFail($id);

            return response()->json(new DenunciaResource($den));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Denúncia não encontrada'], 404);
        }
    }

    public function store(DenunciaRequest $request): JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $den = Denuncia::create($data);

            if ($request->filled('denunciantes')) {
                $den->denunciantes()->attach($request->input('denunciantes'));
            }

            DB::commit();
            return (new DenunciaResource(
                $den->load(['denunciantes', 'denunciado', 'administrador', 'viagem'])
            ))->response()->setStatusCode(201);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar denúncia: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar denúncia'], 500);
        }
    }


    public function update(DenunciaRequest $request, $id = null): JsonResponse
    {
        if (empty($id)) {
            return response()->json(['message' => 'ID da denúncia não informado'], 400);
        }

        DB::beginTransaction();
        try {
            $den = Denuncia::findOrFail($id);

            $den->update($request->validated());

            if ($request->has('denunciantes')) {
                $den->denunciantes()->sync($request->input('denunciantes'));
            }

            DB::commit();
            return response()->json(
                new DenunciaResource(
                    $den->load(['denunciantes', 'denunciado', 'administrador', 'viagem'])
                )
            );

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Denúncia não encontrada'], 404);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao atualizar denúncia ' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar denúncia'], 500);
        }
    }


    public function updateStatus(DenunciaStatusRequest $request, $id): JsonResponse
    {
        try {
            $denuncia = Denuncia::findOrFail($id);

          
            $denuncia->statusDenuncia = $request->status;   // ajuste o nome se necessário
            $denuncia->save();

          
            $denuncia->refresh()->load([
                'denunciantes',
                'denunciado',
                'administrador',
                'viagem',
            ]);

            return response()->json(new DenunciaResource($denuncia));

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Denúncia não encontrada'], 404);

        } catch (\Throwable $e) {
            \Log::error("Erro ao atualizar status da denúncia {$id}: {$e->getMessage()}");
            return response()->json(['message' => 'Erro ao atualizar status'], 500);
        }
    }


    public function destroy($id = null): JsonResponse
    {
        if (empty($id)) {
            return response()->json(['message' => 'ID da denúncia não informado'], 400);
        }

        try {
            $den = Denuncia::findOrFail($id);
            $den->denunciantes()->detach();
            $den->delete();

            return response()->json(['message' => 'Denúncia removida']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Denúncia não encontrada'], 404);
        }
    }
}