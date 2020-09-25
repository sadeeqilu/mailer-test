<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\GeneralResource;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends BaseController
{
    protected $transactionModel, $accountModel;

    public function __construct(Transaction $transaction,Account $account)
    {
        $this->accountModel = $account;
        $this->transactionModel = $transaction;
    }

    /**
     * @OA\Get(
     ** path="/api/transactions/get-transaction/{account_id}",
     *   tags={"Transactions"},
     *   summary="Get account transactions",
     *   operationId="account transactions",
     *
     *      @OA\Parameter(
     *      name="account_id",
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
     * get all transactions api
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $trans = Transaction::where([
            'from' => $id
        ])->orWhere([
            'to' => $id
        ])->get();
        $transactions = [];
        foreach ($trans as $tran)
        {
            $tran->debited;
            $tran->credited;
            array_push($transactions,$tran);
        }
//        $transactions = array_merge($account['debits']->toArray(),$account['credits']->toArray());
        return $this->successfulResponse(GeneralResource::collection($transactions),trans('api.retrieved'));
    }

    /**
     * @OA\Post (
     ** path="/api/transactions/make-transaction/{account_id}",
     *   tags={"Transactions"},
     *   summary="Make a transaction",
     *   operationId="make account transaction",
     *
     *      @OA\Parameter(
     *      name="account_id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="from",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="to",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="details",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
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
     * make a transaction api
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeTransaction(TransactionRequest $request,$id)
    {
        $data = $request->all();
        if (!$sender = Account::find($id))
            return $this->sendError("Sender account not found",[]);
        if (!$receiver = Account::find($data['to']))
            return $this->sendError("Receiver account not found",[]);
        if ($sender->balance - $data['amount'] < 0)
            return $this->sendError("Insufficient balance",[]);
        if ($sender->id == $receiver->id)
            return $this->sendError("You can't transfer money to yourself",[]);
        DB::beginTransaction();
        $this->accountModel->deductFromBalance($sender,$data['amount']);
        $this->accountModel->addToBalance($receiver,$data['amount']);
        $data['from'] = $sender->id;
        $transaction = $this->transactionModel->makeTransaction($data);
        DB::commit();

        $transaction->debited;
        $transaction->credited;
        return $this->successfulResponse(new GeneralResource($transaction),"Transaction complete");
    }
}
