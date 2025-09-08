<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Pagination;
use App\Http\Requests\NivelIndexRequest;
use App\Http\Requests\NivelStoreRequest;
use App\Http\Requests\NivelUpdateRequest;
use App\Models\Nivel;

class NivelController extends Controller
{
    use Pagination;

    /**
     * @OA\Get(
     *   path="/api/niveis", summary="Listar níveis", tags={"Níveis"},
     *
     *   @OA\Parameter( name="nivel", in="query", description="Filtro pelo nome do nível", required=false, @OA\Schema(type="string") ),
     *   @OA\Parameter( name="page", in="query", description="Número da página para paginação", required=false, @OA\Schema(type="integer", default=1) ),
     *   @OA\Parameter( name="limit", in="query", description="Número de itens por página para paginação", required=false, @OA\Schema(type="integer", default=10) ),
     *   @OA\Parameter( name="order_by", in="query", description="Campo para ordenar os resultados (id, nivel)", required=false, @OA\Schema(type="string", default="id") ),
     *   @OA\Parameter( name="order_direction", in="query", description="Direção da ordenação (asc ou desc)", required=false, @OA\Schema(type="string", enum={"asc", "desc"}, default="asc") ),
     *
     *   @OA\Response( response=200, description="Lista de níveis retornada com sucesso" )
     * )
     */
    public function index(NivelIndexRequest $req)
    {
        $query = Nivel::query();

        $nivel = $req->query('nivel');
        if ($nivel) {
            $query->where('nivel', 'like', '%'.$nivel.'%');
        }

        $query->orderBy($req->query('order_by', 'id'), $req->query('order_direction', 'asc'));

        $niveis = $this->paginate($query, $req);

        return $niveis['meta']['total']
                ? response()->json($niveis)
                : response()->json(['message' => 'Nenhum nível encontrado'], 404);
    }

    /**
     * @OA\Get(
     *   path="/api/niveis/{id}", summary="Obter detalhes de um nível", tags={"Níveis"},
     *
     *   @OA\Parameter( name="id", in="path", description="ID do nível", required=true, @OA\Schema(type="integer") ),
     *
     *   @OA\Response( response=200, description="Detalhes do nível retornados com sucesso" ),
     *   @OA\Response( response=404, description="Nível não encontrado" )
     * )
     */
    public function show(int $id)
    {
        $nivel = Nivel::find($id);

        if (! $nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }

        return response()->json($nivel);
    }

    /**
     * @OA\Post(
     *   path="/api/niveis", summary="Criar um novo nível", tags={"Níveis"},
     *
     *   @OA\RequestBody( required=true,
     *
     *     @OA\JsonContent( required={"nivel"}, @OA\Property(property="nivel", type="string", maxLength=255, example="Júnior") )
     *   ),
     *
     *   @OA\Response( response=201, description="Nível criado com sucesso"),
     *   @OA\Response( response=400, description="Requisição inválida")
     * )
     */
    public function store(NivelStoreRequest $req)
    {
        $data = $req->only(['nivel']);

        $nivel = Nivel::create($data);

        return response()->json($nivel, 201);
    }

    /**
     * @OA\Put(
     *   path="/api/niveis/{id}", summary="Atualizar um nível existente", tags={"Níveis"},
     *
     *   @OA\Parameter( name="id", in="path", description="ID do nível", required=true, @OA\Schema(type="integer") ),
     *
     *   @OA\RequestBody( required=true,
     *
     *     @OA\JsonContent( required={"nivel"}, @OA\Property(property="nivel", type="string", maxLength=255, example="Pleno") )
     *   ),
     *
     *   @OA\Response( response=200, description="Nível atualizado com sucesso" ),
     *   @OA\Response( response=400, description="Requisição inválida" ),
     *   @OA\Response( response=404, description="Nível não encontrado" )
     * )
     */
    public function update(NivelUpdateRequest $req, int $id)
    {
        $nivel = Nivel::find($id);

        if (! $nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }

        $jaExiste = Nivel::where('nivel', $req->nivel)->where('id', '!=', $id)->exists();

        if ($jaExiste) {
            return response()->json(['message' => 'O nível informado já existe'], 400);
        }

        $data = $req->only(['nivel']);

        $nivel->update($data);

        return response()->json($nivel);
    }

    /**
     * @OA\Delete(
     *   path="/api/niveis/{id}", summary="Deletar um nível", tags={"Níveis"},
     *
     *   @OA\Parameter( name="id", in="path", description="ID do nível", required=true, @OA\Schema(type="integer") ),
     *
     *   @OA\Response( response=204, description="Nível deletado com sucesso" ),
     *   @OA\Response( response=400, description="Não é possível deletar um nível que possui desenvolvedores associados" ),
     *   @OA\Response( response=404, description="Nível não encontrado" )
     * )
     */
    public function destroy(int $id)
    {
        $nivel = Nivel::find($id);

        if (! $nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }

        if ($nivel->desenvolvedores()->count() > 0) {
            return response()->json(['message' => 'Não é possível deletar um nível que possui desenvolvedores associados'], 400);
        }

        $nivel->delete();

        return response()->json(null, 204);
    }
}
