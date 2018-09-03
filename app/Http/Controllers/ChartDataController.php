<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ChartDataController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChartData(){
        $result = DB::table('trade_data')->select('trade_date', 'open_bid', 'high_bid', 'low_bid', 'close_bid')
                  ->where('id_currency', 1)->get();
        $data = array();
        foreach($result as $item){
            $time = strtotime($item->trade_date);
            $row = array(date("U", $time)*1000,
                         $item->open_bid,
                         $item->high_bid,
                         $item->low_bid,
                         $item->close_bid
                    );
            $data[] = $row;
        }

        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents(base_path('public/files/tradingData.json'), stripslashes($newJsonString));

        return response()->json(array('status' => true));
    }

    function getTrendLines(){
        $param = array( "enabled"=>true,
                        "type"=>"vertical-line",
                        "color"=>"#e06666",
                        "allowEdit"=>true,
                        "hoverGap"=>5,
                        "normal"=>array("markers"=>array(   "enabled"=>false,
                                                            "anchor"=>"center",
                                                            "offsetX"=>0,
                                                            "offsetY"=>0,
                                                            "type"=>"square",
                                                            "rotation"=>0,
                                                            "size"=>10,
                                                            "fill"=>"#ffff66",
                                                            "stroke"=>"#333333"
                                                    )
                                        ),
                        "hovered"=>array("markers"=>array("enabled"=>null)),
                        "selected"=>array("markers"=>array("enabled"=>true))
                        ,"xAnchor"=>0
                    );
        $data = array();
        $result = DB::table('trend_markers')->where("id_currency", 1)->get();
        foreach($result as $item){
            $row = $param;
            $row['xAnchor'] = $item->xAnchor;
            $data[] = $row;
        }
        return response()->json(json_encode(array("annotationsList"=>$data)));
    }
}
