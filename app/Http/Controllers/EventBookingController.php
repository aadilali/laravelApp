<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\EventBooking;

class EventBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Display List of bookings
        $bookingevents = EventBooking::all();
        return response(['data' => $bookingevents],200);

    }


    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'book_date' => ['required'],
            'participants' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
        $data = $request->all();
        $errors = $this->validator($data)->errors();
        if(count($errors) > 0 )
        {
            return response(['errors' => $errors], 400);
        }

        //Get Logged in user id
        if(! $request->auth->id)
        {
            return response(['errors' => 'User not logged in'], 401);
        }
        if(empty($request['event_id']))
        {
            return response(['errors' => 'Please select atleast 1 event'], 400);
        }

        $post = EventBooking::create([
            'book_date' => $data['book_date'],
            'participants'  => $data['participants'],
            'book_notes' => isset($data['book_notes'])?$data['book_notes']:NULL,
            'user_id' => $request->auth->id,
            'event_ids' => implode(',', $request['event_id'])
            ]);
        
        return response(['success' => 'Event is created successfully', 'data' => $post], 200);
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
        $event = EventBooking::where('id', $id)->get();

        if(count($event) > 0)
        {
            return response(['data' => $event], 200);
        }
        return response(['data' => 'Event not found!'], 200);
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
        EventBooking::destroy($id);
        
        return response(['data' => 'Event booking is successfully deleted!'], 200);
    }
}
