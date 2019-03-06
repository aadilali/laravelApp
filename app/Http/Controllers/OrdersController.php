<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Orders;
use App\OrderItems;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Orders by Logged in Customer
        // $orders = DB::table('orders')
        //     ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        //     ->select('orders.*', 'order_items.*')
        //     ->get();
         $orders = Orders::where('customer_id', 1)->get();
         foreach($orders as $key => $item)
         {
            $orders[$key]->paramList = json_decode($item->cart_details);
         }
        // $order_items = OrderItems::where('order_id', $orders->id)->get();
        // $order['orderItems'] = $order_items;
        return response(['status' => true, 'data' => $orders], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
        // $errors = $this->validator($data)->errors();
        // if(count($errors) > 0 )
        // {
        //     return response(['message' => $errors], 400);
        // }

        // $uploadedFile = null;
        // if ($files = $request->eventImages) {
        //     $destinationPath = '/uploads/events-images/'; // upload path
        //     $fileName = time().$files->getClientOriginalName();
        //     $files->move($destinationPath, $fileName);
        //     $uploadedFile = $destinationPath.$fileName;
        //  }
        
        $order = Orders::create([
            'order_id' => $data['orderId'],
            'event_date'  => $data['eventDate'],
            'participants' => $data['participants'],
            'event_time' => $data['eventTime'],
            'zip_code' => $data['zipCode'],
            'event_notes' => $data['eventNotes'],
            'sub_total' => $data['subTotal'],
            'cart_details' => json_encode($data['paramList']),
            'customer_id' =>  $request->auth->id
            ]);
        
        
        foreach($data['paramList'] as $key => $item)
        {
            $order_items = $order->orderItems()->create([
                'event_id' => $item['eventId'],
                'unit_price' => $item['unitPrice']
            ]);
        }        

        //$order_items = $order->orderItems()->create($order_items_arr);
        
        return response(['success' => 'Order is placed successfully', 'data' => $order], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
