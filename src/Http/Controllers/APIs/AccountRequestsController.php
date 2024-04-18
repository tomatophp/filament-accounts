<?php

namespace TomatoPHP\FilamentAccounts\Http\Controllers\APIs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Models\AccountRequest;

class AccountRequestsController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountRequest::query();
        $query->where('account_id',$request->user()->id);
        $query->with('accountRequestMetas');

        return Response::data($query->paginate(10), 'Account Requests Loaded Successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|max:255|string',
            'payload' => 'required|array|min:1',
        ]);


        $accountRequest = AccountRequest::query()->create([
            'account_id' => $request->user()->id,
            "type" => $request->get('type'),
        ]);

        foreach ($request->get('payload') as $key=>$item){
            $accountRequest->accountRequestMetas()->create([
                'key' => $key,
                'value' => $item
            ]);
        }

        $accountRequest->load('accountRequestMetas');

        return Response::data($accountRequest, 'Account Request Created Successfully');
    }

    public function show(AccountRequest $accountRequest, Request $request)
    {
        if($accountRequest->account_id === $request->user()->id ) {
            $accountRequest->load('accountRequestMetas');
            return Response::data($accountRequest, 'AccountRequest Loaded Successfully');
        }

        return Response::errors('Sorry You do not have access to this request', null, 403);
    }

    public function update(AccountRequest $accountRequest, Request $request)
    {
        if($accountRequest->account_id === $request->user()->id ) {
            $request->validate([
                'type' => 'sometimes|max:255|string',
                'payload' => 'sometimes|array|min:1',
            ]);

            if($request->has('type')){
                $accountRequest->update([
                    "type" => $request->get('type'),
                ]);
            }


            foreach ($request->get('payload') as $key=>$item){
                $accountRequest->accountRequestMetas()->where([
                    'key' => $key
                ])->update([
                    'value' => is_string($item) ? json_encode($item) : $item
                ]);
            }

            $accountRequest->load('accountRequestMetas');

            return Response::data($accountRequest, 'Account Request Loaded Successfully');
        }

        return Response::errors('Sorry You do not have access to this request', null, 403);
    }

    public function destroy(AccountRequest $accountRequest, Request $request)
    {
        if($accountRequest->account_id === $request->user()->id ) {
            $accountRequest->delete();
            return Response::success('Account Request Deleted Successfully');
        }

        return Response::errors('Sorry You do not have access to this request', null, 403);
    }
}
