<?php

namespace App\Http\Controllers;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiFisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json();
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
        // data
        $new = new News();
        $new->author = $request->name;
        $new->location = $request->location;
        $new->news = $request->headline;
        if ($new->save()){
            $url = "https://newsapi.org/v2/everything?q=".$request->headline."&apiKey=".config('newsapi.api_key');
            $s = curl_init();
            curl_setopt($s,CURLOPT_URL,$url);
            curl_setopt($s, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Content-length:0')); //setting custom header
            curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
            $curl_response=curl_exec($s);
            $data = json_decode($curl_response);

            if ($data != null) {
                return response()->json([
                    'fake'=>false,
                    'news'=>$data->articles
                ]);
            }
            // false no news about it...
            return response()->json([
                'fake'=>true
            ]);

        }
        return response()->json([
            'fake'=>0
        ]);
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
