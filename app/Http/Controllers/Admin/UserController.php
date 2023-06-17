<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Services\Admin\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Info(title="API Taxis", version="1.0")
 *
 * @OA\Server(url="http://cooperativa-taxi.local")
 */
class UserController extends Controller
{
    /** @var UserService */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Get all users",
     *     @OA\Parameter(
     *          name="page",
     *          required=true,
     *          in="query",
     *          example=1,
     *          description="page number of the list"
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="status filter"
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Show all the users",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/User")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="We have an error"
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $meta = $request->all();
        return response()->json($this->userService->getAll($meta), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *      summary="Get one user",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="user id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Show the user information by Id",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="We have an error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *          )
     *      )
     *)
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function get(Request $request): JsonResponse
    {
        $userId = $request->route('id');
        try {
            $user = $this->userService->getUserById($userId);
            return response()->json(
                $user,
                Response::HTTP_OK
            );
        }catch (ModelNotFoundException $e){
            return response()->json(
                ['message' => "The user does not exists."],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Create  a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Create  a new user",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="We have an error"
     *     )
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function store(Request $request): JsonResponse
    {
        $newUser = $request->all();
        return response()->json($this->userService->createUser($newUser), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Update  a user",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="user id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Update  a user",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="We have an error",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function update(Request $request): JsonResponse
    {
        $userId = $request->route('id');
        $newUser = $request->all();

        try {
            $result = $this->userService->getUserById($userId);
            return response()->json($this->userService->updateUser($userId, $newUser), Response::HTTP_OK);
        }catch (ModelNotFoundException $e){
            return response()->json(
                ['message' => "The user does not exists."],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}/status/{status}",
     *     tags={"User"},
     *     summary="Change the user status",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="user id"
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="path",
     *          description="user id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Change the user status"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="We have an error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $userId = $request->route('id');
        $status = $request->route('status');

        try {
            $result = $this->userService->getUserById($userId);
            return response()->json($this->userService->changeUserStatus($userId, $status), Response::HTTP_OK);
        }catch (ModelNotFoundException $e){
            return response()->json(
                ['message' => "The user does not exists."],
                Response::HTTP_NOT_FOUND
            );
        }


    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Delete  a new user",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="user id"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Delete a user"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="We have an error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function remove(Request $request): JsonResponse
    {
        $userId = $request->route('id');
        try {
            $result = $this->userService->getUserById($userId);
            $this->userService->removeUser($userId);
            return response()->json('', Response::HTTP_NO_CONTENT);
        }catch (ModelNotFoundException $e){
            return response()->json(
                ['message' => "The user does not exists."],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
