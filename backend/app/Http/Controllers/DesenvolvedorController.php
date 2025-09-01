<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesenvolvedorIndexRequest;
use App\Http\Requests\DesenvolvedorStoreRequest;
use App\Models\Desenvolvedor;
use App\Traits\Pagination;

class DesenvolvedorController extends Controller
{
    use Pagination;

    /**
     * @OA\Get(
     *   path="/api/desenvolvedores", summary="Listar desenvolvedores", tags={"Desenvolvedores"},
     *   @OA\Parameter( name="nivel_id", in="query", description="Filtro pelo ID do nível", required=false, @OA\Schema(type="integer") ),
     *   @OA\Parameter( name="nome", in="query", description="Filtro pelo nome do desenvolvedor", required=false, @OA\Schema(type="string") ),
     *   @OA\Parameter( name="sexo", in="query", description="Filtro pelo sexo do desenvolvedor (M ou F)", required=false, @OA\Schema(type="string", enum={"M", "F"}) ),
     *   @OA\Parameter( name="hobby", in="query", description="Filtro pelo hobby do desenvolvedor", required=false, @OA\Schema(type="string") ),
     *   @OA\Parameter( name="data_nascimento", in="query", description="Filtro pela data de nascimento do desenvolvedor (YYYY-MM-DD)", required=false, @OA\Schema(type="string", format="date") ),
     *   @OA\Parameter( name="page", in="query", description="Número da página para paginação", required=false, @OA\Schema(type="integer", default=1) ),
     *   @OA\Parameter( name="limit", in="query", description="Número de itens por página para paginação", required=false, @OA\Schema(type="integer", default=10) ),
     *   @OA\Response( response=200, description="Lista de desenvolvedores retornada com sucesso" )
     * )
     */
    public function index(DesenvolvedorIndexRequest $req)
    {
        $query = Desenvolvedor::query();

        $filters = $req->only(['nivel_id', 'nome', 'sexo', 'hobby', 'data_nascimento']);

        foreach ($filters as $field => $value) {
            if ($value) {
                if (in_array($field, ['nome', 'hobby'])) {
                    $query->where($field, 'like', "%$value%");
                } else {
                    $query->where($field, $value);
                }
            }
        }

        $desenvolvedores = $this->paginate($query, $req);

        return $desenvolvedores['meta']['total']
                ? response()->json($desenvolvedores)
                : response()->json(['message' => 'Nenhum desenvolvedor encontrado'], 404);
    }

    /**
     * @OA\Get(
     *   path="/api/desenvolvedores/{id}", summary="Obter detalhes de um desenvolvedor", tags={"Desenvolvedores"},
     *   @OA\Parameter( name="id", in="path", description="ID do desenvolvedor", required=true, @OA\Schema(type="integer") ),
     *   @OA\Response( response=200, description="Detalhes do desenvolvedor retornados com sucesso" ),
     *   @OA\Response( response=404, description="Desenvolvedor não encontrado" )
     * )
     */
    public function show(int $id)
    {
        $nivel = Desenvolvedor::find($id);

        if (!$nivel) {
            return response()->json(['message' => 'Desenvolvedor não encontrado'], 404);
        }

        return response()->json($nivel);
    }

    /**
     * @OA\Post(
     *   path="/api/desenvolvedores", summary="Criar um novo desenvolvedor", tags={"Desenvolvedores"},
     *   @OA\RequestBody( required=true,
     *     @OA\JsonContent( required={"nivel_id","nome","sexo","data_nascimento"},
     *       @OA\Property(property="nivel_id", type="integer", example=1),
     *       @OA\Property(property="nome", type="string", maxLength=255, example="João Silva"),
     *       @OA\Property(property="sexo", type="string", enum={"M","F"}, example="M"),
     *       @OA\Property(property="hobby", type="string", maxLength=255, example="Futebol"),
     *       @OA\Property(property="data_nascimento", type="string", format="date", example="1990-05-15")
     *     )
     *   ),
     *   @OA\Response( response=201, description="Desenvolvedor criado com sucesso" ),
     *   @OA\Response( response=422, description="Erro de validação" )
     * )
     */
    public function store(DesenvolvedorStoreRequest $req)
    {
        $data = $req->only(['nivel_id', 'nome', 'sexo', 'data_nascimento', 'hobby']);

        $desenvolvedor = Desenvolvedor::create($data);

        return response()->json($desenvolvedor, 201);
    }

    /**
     * @OA\Put(
     *   path="/api/desenvolvedores/{id}", summary="Atualizar um desenvolvedor existente", tags={"Desenvolvedores"},
     *   @OA\Parameter( name="id", in="path", description="ID do desenvolvedor", required=true, @OA\Schema(type="integer") ),
     *   @OA\RequestBody( required=true,
     *     @OA\JsonContent( required={"nivel_id","nome","sexo","data_nascimento"},
     *       @OA\Property(property="nivel_id", type="integer", example=2),
     *       @OA\Property(property="nome", type="string", maxLength=255, example="Maria Souza"),
     *       @OA\Property(property="sexo", type="string", enum={"M","F"}, example="F"),
     *       @OA\Property(property="hobby", type="string", maxLength=255, example="Leitura"),
     *       @OA\Property(property="data_nascimento", type="string", format="date", example="1985-10-20")
     *     )
     *   ),
     *   @OA\Response( response=200, description="Desenvolvedor atualizado com sucesso" ),
     *   @OA\Response( response=404, description="Desenvolvedor não encontrado" ),
     *   @OA\Response( response=422, description="Erro de validação" )
     * )
     */
    public function update(DesenvolvedorStoreRequest $req, int $id)
    {
        $desenvolvedor = Desenvolvedor::find($id);

        if (!$desenvolvedor) {
            return response()->json(['message' => 'Desenvolvedor não encontrado'], 404);
        }

        $data = $req->only(['nivel_id', 'nome', 'sexo', 'data_nascimento', 'hobby']);

        $desenvolvedor->update($data);

        return response()->json($desenvolvedor);
    }

    /**
     * @OA\Delete(
     *   path="/api/desenvolvedores/{id}", summary="Deletar um desenvolvedor", tags={"Desenvolvedores"},
     *   @OA\Parameter( name="id", in="path", description="ID do desenvolvedor", required=true, @OA\Schema(type="integer") ),
     *   @OA\Response( response=204, description="Desenvolvedor deletado com sucesso" ),
     *   @OA\Response( response=404, description="Desenvolvedor não encontrado" )
     * )
     */
    public function destroy(int $id)
    {
        $desenvolvedor = Desenvolvedor::find($id);

        if (!$desenvolvedor) {
            return response()->json(['message' => 'Desenvolvedor não encontrado'], 404);
        }

        $desenvolvedor->delete();

        return response()->json(null, 204);
    }
}
