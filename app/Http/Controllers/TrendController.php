<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TrendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('currency')->select('id_currency', 'currency_name')->get();
        $data = array();
        foreach($result as $item){
            $row = array();
            $row['id'] = $item->id_currency;
            $row['item'] = $item->currency_name;
            $data[] = $row;
        }
        return view('backend.trend', ['js' => 'trend', 'menu' => 'Trend', 'select2' => $data]);
    }

    public function getJsonData(){
        $result = DB::table('trade_data')->select('trade_date', 'open_bid', 'high_bid', 'low_bid', 'close_bid')->limit(1000)->get();
        $data = array();
        foreach($result as $item){
            $time = strtotime($item->trade_date);
            $utc_time = mktime( date("H", $time),
                                date("i", $time),
                                0,
                                date("d", $time),
                                date("m", $time),
                                date("Y", $time)
                        );
            $row = array($utc_time*1000,
                         $item->open_bid,
                         $item->high_bid,
                         $item->low_bid,
                         $item->close_bid
                        );
            $data[] = $row;
        }
        return response()->json($data);
    }

    function saveTrendLines(Request $request){
        $arr[] = ['id_currency' => $request->input('id_currency'),
                  'enabled' => $request->input('enabled'),
                  'type' => $request->input('type'),
                  'color' => $request->input('color'),
                  'xAnchor' => $request->input('xAnchor'),
                  'secondXAnchor' => $request->input('secondXAnchor'),
                  'valueAnchor' => $request->input('valueAnchor'),
                  'secondValueAnchor' => $request->input('secondValueAnchor'),
        ];
        $status = DB::table('zones')->insert($arr);
        return response()->json(array('status'=>$status));
    }

    function removeTrendLines(Request $request){
        DB::table('zones')->where('id_currency', $request->input('id_currency'))
           ->where('color', $request->input('color'))
           ->where('xAnchor', $request->input('xAnchor'))
           ->where('secondXAnchor', $request->input('secondXAnchor'))
           ->delete();
        return response()->json(json_encode(array('status'=>true)));
    }

    function getTrendLines(Request $request){
        // $param = array( "enabled"=>true,
        //                 "type"=>"vertical-line",
        //                 "color"=>"#e06666",
        //                 "allowEdit"=>true,
        //                 "hoverGap"=>5,
        //                 "normal"=>array("markers"=>array(   "enabled"=>false,
        //                                                     "anchor"=>"center",
        //                                                     "offsetX"=>0,
        //                                                     "offsetY"=>0,
        //                                                     "type"=>"square",
        //                                                     "rotation"=>0,
        //                                                     "size"=>10,
        //                                                     "fill"=>"#ffff66",
        //                                                     "stroke"=>"#333333"
        //                                             )
        //                                 ),
        //                 "hovered"=>array("markers"=>array("enabled"=>null)),
        //                 "selected"=>array("markers"=>array("enabled"=>true))
        //                 ,"xAnchor"=>0
        //             );
        $data = array();
        $result = DB::table('zones')->where("id_currency",  $request->input('id_currency'))->get();
        foreach($result as $item){
            $row = array(
                'enabled' => $item->enabled,
                'type' => $item->type,
                'color' => $item->color,
                'xAnchor' => $item->xAnchor,
                'secondXAnchor' => $item->secondXAnchor,
                'valueAnchor' => $item->valueAnchor,
                'secondValueAnchor' => $item->secondValueAnchor,
            );
            $data[] = $row;
        }
        return response()->json(json_encode(array("annotationsList"=>$data)));
    }

    public function saveToJsonFile(Request $request){
        $response = array(
            'status' => true,
            'title' => "Money Exchange",
            'filename' => 'emptyData.json',
            'name' => 'N/A',
            'minDate' => date("Y-m-d").' 00:00:00',
            'maxDate' => date("Y-m-d").' 16:58:00',
        );

        if($request->input('id_currency') != ""){
            $result = DB::table('trade_data')->select('trade_date', 'open_bid', 'high_bid', 'low_bid', 'close_bid')
                    ->where('id_currency', $request->input('id_currency'))->get();
            $data = array();

            $count = 1;
            $total = $result->count();
            foreach($result as $item){
                if($count == 1){
                    $response['minDate'] = $item->trade_date;
                }elseif($count ==  $total){
                    $response['maxDate'] = $item->trade_date;
                }
                $time = strtotime($item->trade_date);
                $row = array(date("U", $time)*1000,
                            $item->open_bid,
                            $item->high_bid,
                            $item->low_bid,
                            $item->close_bid
                        );
                $data[] = $row;
                $count++;
            }

            $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

            $response['title'] = "Money Exchange ".substr($request->input('currency'), 0, 3)." - ".substr($request->input('currency'), 3, 3);
            $response['filename'] = $request->input('currency').'.json';
            $response['name'] = $request->input('currency');

            file_put_contents(base_path('public/files/'.$request->input('currency').'.json'), stripslashes($newJsonString));
        }


        return response()->json($response);
    }

    public function getCurrency(){
        $result = DB::table('currency')->select('id_currency', 'currency_name')->get();
        $data = array();
        foreach($result as $item){
            $row = array();
            $row['id'] = $item->id_currency;
            $row['item'] = $item->currency_name;
            $data[] = $row;
        }

        return response()->json($data);
    }


}
