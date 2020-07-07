<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQrcodeRequest;
use App\Http\Requests\UpdateQrcodeRequest;
use App\Repositories\QrcodeRepository;
use App\Http\Controllers\AppBaseController;
//use App\Models\Qrcode;
use App\Models\Qrcode as QrcodeModel;
use App\Http\Resources\Qrcode as QrcodeResource;
use App\Http\Resources\QrcodeCollection as QrcodeResourceCollection;
use App\Models\User;
use App\Models\Transaction;
use QRCode;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;


class QrcodeController extends AppBaseController
{
    /** @var  QrcodeRepository */
    private $qrcodeRepository;

    public function __construct(QrcodeRepository $qrcodeRepo)
    {
        $this->qrcodeRepository = $qrcodeRepo;
    }

    /**
     * Display a listing of the Qrcode.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //Only admin should see all Qrcodes
        if(Auth::user()->role_id < 3){
            $qrcodes = $this->qrcodeRepository->paginate(5);
        } else {
            $qrcodes = QrcodeModel::where('user_id', Auth::user()->id)->paginate(5);
        }

        if ($request->expectsJson()){
            return QrcodeResourceCollection::collection($qrcodes);
        }
        
          return view('qrcodes.index')
            ->with('qrcodes', $qrcodes);
    }

    public function show_payment_page(Request $request){
        //Recieve the buyer email
        //Retrieve the user_id using the buyer email
        //Initiate transaction
        //Redirect to paystack payment page
        $input = $request->all(); 
        //Get the user with this email
        //$input['email'];
        $user = User::where('email', $input['email'])->first();
        if(empty($user)){//user does not exist
            //create user account
            $user = User::create([
                'name' => $input['email'],
                'email' => $input['email'],
                'password' => Hash::make($input['email']),
            ]);
        }
        //Get the qrcode details
        $qrcode = QrcodeModel::where('id', $input['qrcode_id'])->first();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'qrcode_id' => $qrcode->id,
            'status' => 'initiated',
            'qrcode_owner_id' => $qrcode->user_id,
            'payment_method' => 'paystack/card',
            'amount' => $qrcode->amount,
        ]);
        return view('qrcodes.paystack-form', ['qrcode' => $qrcode, 'user' => $user, 'transaction' => $transaction]);
    }

    /**
     * Show the form for creating a new Qrcode.
     *
     * @return Response
     */
    public function create()
    {
        return view('qrcodes.create');
    }

    /**
     * Store a newly created Qrcode in storage.
     *
     * @param CreateQrcodeRequest $request
     *
     * @return Response
     */
    public function store(CreateQrcodeRequest $request)
    {
        $input = $request->all();
        //save data to the database
        $qrcode = $this->qrcodeRepository->create($input);
        //generate qrcode
        //save qrcode image in our folder on this site
        $file = 'myqrcode/'.$qrcode->id.'.png'; 
        $newQrcode = QRCode::text("Message")
        ->setSize(8)
        ->setMargin(2)
        ->setOutfile($file)
        ->png();
         $input['qrcode_path'] = $file; 
        //update database
         $newQrcode =   QrcodeModel::where('id', $qrcode->id)
            ->update([
                'qrcode_path' => $input['qrcode_path']
            ]);
        if($newQrcode){
            $getQrcode =  QrcodeModel::where('id', $qrcode->id)->first();
            //check if request expects json 
            //docs: https://laravel.com/api/5.6/Illuminate/Http/Request.html
            if($request->expectsJson()){
                return response([
                    'data' => new QrcodeResource($getQrcode)
                ], Response::HTTP_CREATED); 
            }  
        Flash::success('Qrcode generated successfully.');
        }else{
        Flash::error('Qrcode failed to generate successfully.');
        }
        //return redirect(route('qrcodes.show', ['qrcode' => $qrcode]));
        return redirect(route('qrcodes.index'));
    }

    /**
     * 
     * Display the specified Qrcode.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $qrcode = $this->qrcodeRepository->find($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }
        $transactions = $qrcode->transactions;
        if ($request->expectsJson()){
            return new QrcodeResourceCollection($qrcode);
        }
        return view('qrcodes.show')
        ->with('qrcode', $qrcode)
        ->with('transactions', $transactions);
    }

    /**
     * Show the form for editing the specified Qrcode.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $qrcode = $this->qrcodeRepository->find($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        return view('qrcodes.edit')->with('qrcode', $qrcode);
    }

    /**
     * Update the specified Qrcode in storage.
     *
     * @param int $id
     * @param UpdateQrcodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQrcodeRequest $request)
    {
        $qrcode = $this->qrcodeRepository->find($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $qrcode = $this->qrcodeRepository->update($request->all(), $id);
        $file = 'myqrcode/'.$qrcode->id.'.png'; 
        $newQrcode = QRCode::text("Message")
        ->setSize(8)
        ->setMargin(2)
        ->setOutfile($file)
        ->png();
         $input['qrcode_path'] = $file; 
        //update database
         $newQrcode =   QrcodeModel::where('id', $qrcode->id)
            ->update([
                'qrcode_path' => $input['qrcode_path']
            ]);

        $getQrcode =  QrcodeModel::where('id', $qrcode->id)->first();
            //check if request expects json 
            //docs: https://laravel.com/api/5.6/Illuminate/Http/Request.html
            if($request->expectsJson()){
                return response([
                    'data' => new QrcodeResource($getQrcode)
                ], Response::HTTP_CREATED); 
            }  
        Flash::success('Qrcode updated successfully.');

        return redirect(route('qrcodes.show', ['qrcode' =>  $qrcode]));
    }

    /**
     * Remove the specified Qrcode from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $qrcode = $this->qrcodeRepository->find($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $this->qrcodeRepository->delete($id);

        Flash::success('Qrcode deleted successfully.');

        return redirect(route('qrcodes.index'));
    }
}
