<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $smsPeriod = $request->period;
        $phoneNo = $request->phone;
        foreach ($fileContents as $line) {
            $smsPeriod += $smsPeriod ;
            $data = str_getcsv($line);
            // $currentDateTime = date('Y-m-d H:i:s'); // Get current date and time
            // $newDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +' . $smsPeriod . ' minutes'));
            //
            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->addMinutes($smsPeriod);
            Sms::create([
                'message' => $data[0],
                'target_phone_no' => $phoneNo,
                'created_at' => date('Y-m-d H:i:s'),
                'sms_sending_time' => $newDateTime,
                'send_flag' => 'N',
            ]);
        }

        return redirect()->back()->with('success', 'CSV imported successfully. SMS will be send to '
            . $phoneNo . ' each ' . $request->period . ' min interval');
    }
}
