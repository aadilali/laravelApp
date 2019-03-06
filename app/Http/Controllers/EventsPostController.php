<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\EventsModel;

class EventsPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category)
    {
        // Display List of events
        $events = EventsModel::where('category', $category)->get();
        if(count($events) > 0)
        {
            return response(['status' => true, 'data' => $events], 200);
        }
        
        return response(['status' => false, 'message' => 'Event not found!'], 200);
    }

    public function getAll()
    {
        // Display List of events
        $events = EventsModel::all();
        if(count($events) > 0)
        {
            return response(['status' => true, 'data' => $events], 200);
        }
        
        return response(['status' => false, 'message' => 'Event not found!'], 200);
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
            'eventTitle' => ['required', 'string', 'max:255'],
            'eventDesc' => ['required', 'string'],
            'eventPrice' => ['required']
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
            return response(['message' => $errors], 400);
        }

        $uploadedFile = null;
        if ($files = $request->eventImages) {
            $destinationPath = '/uploads/events-images/'; // upload path
            $fileName = time().$files->getClientOriginalName();
            $files->move($destinationPath, $fileName);
            $uploadedFile = $destinationPath.$fileName;
         }
        
        $post = EventsModel::create([
            'title' => $data['eventTitle'],
            'desc'  => $data['eventDesc'],
            'price' => $data['eventPrice'],
            'category' => $data['eventCat'],
            'is_featured' => $data['isFeatured'],
            'author_id' => $request->auth->id,
            'image_url' => url('/').$uploadedFile
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
        $event = EventsModel::where('id', $id)->get();

        if(count($event) > 0)
        {
            return response(['data' => $event], 200);
        }
        return response(['data' => 'Event not found!'], 200);
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
        //Validate
        $data = $request->all();
        $errors = $this->validator($data)->errors();
        if(count($errors) > 0 )
        {
            return response(['message' => $errors], 400);
        }

       $post = EventsModel::where('id', $id)
           ->update([
            'title' => $data['title'],
            'desc'  => $data['desc'],
            'author_id' => $data['author_id']
           ]);
        
        return response(['success' => 'Event is updated successfully', 'data' => $post], 200);
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
        EventsModel::destroy($id);
        
        return response(['data' => 'Event is successfully deleted!'], 200);
    }

    /**
     * Display the featured resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function featuredList()
    {
        // Display List of events
        $events = EventsModel::where('is_featured', 1)->get();
        return response(['status' => true, 'data' => $events], 200);
    }
}
