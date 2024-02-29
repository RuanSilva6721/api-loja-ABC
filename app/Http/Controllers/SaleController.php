<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Services\SaleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    protected $saleService;

    protected $rules = [
        'amount' => 'required|integer',
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ];

    protected $messages = [
        'amount.required' => 'O campo amount é obrigatório.',
        'amount.integer' => 'O campo amount deve ser um número.',
        'products.required' => 'O campo products é obrigatório.',
        'products.array' => 'O campo products deve ser um array.',
        'products.*.id.required' => 'Cada produto deve ter um ID.',
        'products.*.id.exists' => 'O ID de algum dos produtos não é válido.',
        'products.*.quantity.required' => 'Cada produto deve ter uma quantidade especificada.',
        'products.*.quantity.integer' => 'A quantidade de cada produto deve ser um número inteiro.',
        'products.*.quantity.min' => 'A quantidade de cada produto deve ser no mínimo 1.',
    ];

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    private function validateSaleId(string $id): void
    {
        Validator::make(['id' => $id], [
            'id' => 'required|string|exists:sales,id',
        ], [
            'id.exists' => 'O ID da venda não é válido.',
        ])->validate();
    }

    private function validateProductId(string $id): void
    {
        Validator::make(['id' => $id], [
            'id' => 'required|exists:products,id',
        ], [
            'id.exists' => 'O ID do produto não é válido.',
        ])->validate();
    }
    /**
         * Display a listing of the resource.
         * @OA\Get(
         *      path="/api/sales",
         *      operationId="index",
         *      tags={"Sales"},
         *      summary="Buscar lista de vendas",
         *      description="Retorna a lista de vendas em formato json",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation"
         *      ),
         * )
         */
    public function index(): JsonResponse
    {
        try {
            $sales = $this->saleService->getAllSales();
            return response()->json($sales, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }
    /**
 * @OA\Schema(
 *     schema="Sale",
 *     title="Sale",
 *     description="Sale model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID da venda"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         description="Quantidade da venda"
 *     ),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         description="Lista de produtos",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", description="ID do produto"),
 *             @OA\Property(property="quantity", type="integer", description="Quantidade do produto")
 *         )
 *     )
 * )
 */
    public function store(Request $request): JsonResponse
    {
        $request->validate($this->rules, $this->messages);

        try {
            $sale = $this->saleService->createSale($request);
            return response()->json(['message' => 'Venda criada com sucesso', 'sale' => $sale], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/sales/{id}",
     *      operationId="show",
     *      tags={"Sales"},
     *      summary="Display a specific sale",
     *      description="Displays the details of a specific sale identified by the provided ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the sale to be displayed",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found. Indicates that the specified sale was not found."
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error. Indicates an unexpected error occurred."
     *      )
     * )
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->validateSaleId($id);

        try {
            $sale = $this->saleService->getSaleByID($id);
            return response()->json($sale, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/sales/{id}",
     *      operationId="destroy",
     *      tags={"Sales"},
     *      summary="Cancel a specific sale",
     *      description="Cancels the sale identified by the provided ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the sale to be canceled",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No Content. Indicates that the sale was successfully canceled."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found. Indicates that the specified sale was not found."
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error. Indicates an unexpected error occurred."
     *      )
     * )
     */

    public function destroy(Request $request, string $id): JsonResponse
    {
        $this->validateSaleId($id);

        try {
            $this->saleService->cancelSaleByID($id);
            return response()->json(['message' => 'Venda cancelada com sucesso'], 204);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }
    /**
     * Add a product to a specific sale.
     *
     * @OA\Post(
     *      path="/api/sales/{id}/add-product",
     *      operationId="addProductForSale",
     *      tags={"Sales"},
     *      summary="Add a product to a sale",
     *      description="Adds a product to the sale identified by the provided ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the sale to which the product will be added",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Product data",
     *          @OA\JsonContent(
     *              required={"products"},
     *              @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  description="List of products to be added",
     *                  @OA\Items(
     *                      required={"id", "quantity"},
     *                      @OA\Property(property="id", type="integer", description="Product ID"),
     *                      @OA\Property(property="quantity", type="integer", description="Product quantity")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request. Indicates a problem with the request body."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found. Indicates that the specified sale was not found."
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error. Indicates an unexpected error occurred."
     *      )
     * )
     */

    public function addProductForSale(Request $request, $id): JsonResponse
    {
        $this->validateSaleId($id);
        $request->validate([
            'products.*.id' => 'required',
            'products.*.quantity' => 'required',
        ]);

        foreach ($request->products as $product) {
            $this->validateProductId($product['id']);
        }

        try {
            $sale = $this->saleService->addProductForSale($id, $request);
            return response()->json($sale, 200);
        } catch (Exception $e) {
            return response()->json(['errors' => ['main' => $e->getMessage()]], 500);
        }
    }
}
