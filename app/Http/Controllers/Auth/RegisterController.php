<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $data = $request->all();
        $errors = $this->validator($data)->errors();
        $user;

        if(count($errors))
        {
            return response()->json([
                'message' => $errors
            ], 400);
        }

        $user = User::create([
            'name' => $data['fullName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('customer');
            
        return $user;
    }

    protected function createVendor(Request $request)
    {
        $data = $request->all();
        // $errors = $this->validator($data)->errors();

        // if(count($errors))
        // {
        //     return response()->json([
        //         'message' => $errors
        //     ], 400);
        // }

        $user = User::create([
            'name' => $data['fullName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('vendor');
        
        $uploadedFile = null;
        if ($files = $request->businessLogo) {
            $destinationPath = public_path().'/uploads/business-logos/'; // upload path
            $fileName = time().$files->getClientOriginalName();
            $files->move($destinationPath, $fileName);
            $uploadedFile = 'uploads/business-logos/'.$fileName;
        }

        $user->businessInfo()->create([
            'company_name' => $data['companyName'],
            'business_address' => $data['businessAddress'],
            'business_website' => $data['businessWebsite'],
            'business_phone' => $data['businessPhone'],
            'business_type' => $data['businessType'],
            'business_desc' => $data['businessDesc'],
            'business_logo' => url('/').$uploadedFile
        ]);
        
        $user->contactInfo()->create([
            'contact_name' => $data['contactName'],
            'contact_email' => $data['contactEmail'],
            'contact_phone' => $data['contactPhone'],
            'contact_position' => $data['contactPosition']
        ]);
        return $user;
    }
}
