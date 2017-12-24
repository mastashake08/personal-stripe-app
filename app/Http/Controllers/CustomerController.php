<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class CustomerController extends Controller
{
    public function __construct(){
      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->expectsJson()){
          return Customer::paginate(10);
        }
        else{
          return view('customers');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
          'email' => 'required|email',
          'plan_id' => 'required'
        ]);
        $cu = \Stripe\Customer::create([
          'email' => $request->email
        ]);
        $customer = Customer::create([
          'email' => $cu->email,
          'customer_id' => $cu->id
        ]);
        $customer->notify(new \App\Notifications\NewSubscription($request->plan_id));
        return response()->json($customer);
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
        $customer = Customer::findOrFail($id);
        $cu = \Stripe\Customer::retrieve($customer->customer_id);
        $cu->delete();
        return response()->json($customer->delete());
    }

    public function completeRegistrationView(Request $request){
      $with = [
        'customer_id' => $request->customer_id,
        'plan_id' => $request->plan_id
      ];
      return view('complete-registration')->with($with);
    }

    public function completeRegistration(Request $request){
      //dd($request->all());
      $client = new \GuzzleHttp\Client();
      // Provide the body as a string.
      $r = $client->request('POST', 'https://box.jyroneparkeremail.space/admin/mail/users/add', [
          'auth' => ['inquiries@jyroneparker.com','n1nt3nd0'],
          'form_params' => [
            'email' => $request->email,
            'password' => $request->password
          ]

      ]);

      $cu = \Stripe\Customer::retrieve($request->customer_id);
      $cu->source = $request->stripeToken;
      $cu->save();
      \Stripe\Subscription::create(array(
        "customer" => $cu->id,
        "items" => array(
          array(
            "plan" => $request->plan_id,
          ),
        )
      ));
      $customer = \App\Customer::where('customer_id',$request->customer_id)->first();
      $customer->notify(new \App\Notifications\NewEmailAccount());
      return redirect('/how-to-check');
    }
}
