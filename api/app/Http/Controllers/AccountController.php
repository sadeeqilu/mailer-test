<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Resources\GeneralResource;
use Illuminate\Http\Request;

class AccountController extends BaseController
{
    protected $accountModel;

    public function __construct(Account $account)
    {
        $this->accountModel = $account;
    }

    /**
     * @OA\Get(
     ** path="/api/accounts/",
     *   tags={"Accounts"},
     *   summary="",
     *   operationId="accounts",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *     )
     *)
     **/
    /**
     * get all accounts api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $accounts = Account::all();
        return $accounts;
    }

    /**
     * @OA\Get(
     ** path="/api/accounts/{id}",
     *   tags={"Accounts"},
     *   summary="Get account info",
     *   operationId="account info",
     *
     *      @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *     )
     *)
     **/
    /**
     * get all accounts api
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        try {
            if ($account = Account::find($id)) {
                $account->debits;
                $account->credits;
                return $this->successfulResponse(new GeneralResource($account), trans('api.retrieved'));
            }
            else return $this->sendError('Error getting account',[]);
        }catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }

    }

    /**
     * @OA\Post (
     ** path="/api/accounts/create-account",
     *   tags={"Accounts"},
     *   summary="Create account",
     *   operationId="create account",
     *
     *      @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="balance",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="currency",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          default="eur",
     *           type="enum['usd','eur']"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *     )
     *)
     **/
    /**
     * create account api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        if (!$account = $this->accountModel->createAccount($data))
            return $this->sendError('Could not create account');
        else return $this->successfulResponse(new GeneralResource($account),'Account created successfully');
    }

    /**
     * @OA\Patch (
     ** path="/api/accounts/update-account/{id}",
     *   tags={"Accounts"},
     *   summary="Update account",
     *   operationId="update account",
     *
     *      @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="balance",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="currency",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          default="eur",
     *           type="enum['usd','eur']"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *     )
     *)
     **/
    /**
     * update account api
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        $data = $request->all();
        if (!$account = $this->accountModel->updateAccount($data,$id))
            return $this->sendError('Could not update account');
        else return $this->successfulResponse(new GeneralResource($account),'Account updated successfully');
    }
}
