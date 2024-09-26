<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\storeDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    protected $itemArray;
    //
    public function __construct()
    {

        $this->itemArray = [
            [
                'id' => 1,
                'store_name' => 'Item Name',
                'qty' => 'qty'
            ],
        ];
    }

    public function Index(Request $request)
    {
        $document_no = rand(1000, 9999);
        $data = $this->itemArray;
        return view('AddDetailView')->with(['data' => $data, 'document_no' => $document_no]);
    }

    public function Store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_email' => 'required|email|unique:customer,email',
            'document_no' => 'required|integer|unique:customer,doc_number',
            'document_date' => 'required|date',
            'store' => 'required|string',
            'qty' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            $insertCustomer = customer::create([
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'doc_number' => $request->document_no,
                'doc_date' => $request->document_date
            ]);

            // return $insertCustomer;
            $insertStore = storeDetails::create([
                'customer_id' => $insertCustomer->id,
                'store_name' => $request->store,
                'qty' => $request->qty
            ]);

            $insertRecord = $insertCustomer->storeDetails;
            return response()->json(['status' => true, 'message' => 'Success!', 'data' => $insertCustomer]);
            // return redirect()->to(route('store.customer'));
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function GetCustomer()
    {
        $customer = customer::all();
        return view('ListingView')->with('data', $customer);
    }
}