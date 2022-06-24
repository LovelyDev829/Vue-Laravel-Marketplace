<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\OrderDetail;
use App\Models\RefundRequest;
use App\Models\RefundRequestItem;
use App\Http\Resources\RefundRequestCollection;
use App\Models\OrderUpdate;
use App\Models\Upload;
use Carbon\Carbon;

class RefundRequestController extends Controller
{
    public function index()
    {
        return new RefundRequestCollection(RefundRequest::with(['shop','order.orderDetails.variation.product','order.orderDetails.variation.combinations'])->where('user_id', auth('api')->user()->id)->latest()->paginate(12));
    }

    public function create($order_id)
    {
        $order = Order::where('id',$order_id)->first();
        if($order){
            if(auth('api')->user()->id == $order->user_id){
                $refund_request = \App\Models\RefundRequest::where('order_id',$order->id)->first();
                $refund_request_order_status = get_setting('refund_request_order_status') != null ? json_decode(get_setting('refund_request_order_status')) : [];
                $last_refund_date = $order->created_at->addDays(get_setting('refund_request_time_period'));
                $today_date = Carbon::now();
                if($refund_request == null && $order->payment_status == 'paid' && in_array($order->delivery_status, $refund_request_order_status) &&  $today_date <= $last_refund_date){

                    return response()->json([
                        'success' => true,
                        'order_code' => $order->combined_order->code,
                        'order' => new OrderResource($order),
                        'has_refund_request' => $refund_request != null ? true : false
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message' => translate("You can't send refund request for this order"),
                        'status' => 200
                    ]);
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => translate("This order is not your. You can't send refund request for this order"),
                    'status' => 200
                ]);
            }
        }
    }

    public function store(Request $request){
        if(empty(json_decode($request->refund_items ?? '[]'))){
            return response()->json([
                'success' => false,
                'message' => translate("Please Select items first."),
            ]);
        }

        $order = Order::with('orderDetails')->find($request->order_id);
        $user = auth('api')->user();

        if(!$order || $user->id != $order->user_id){
            return response()->json([
                'success' => false,
                'message' => translate("Something Went wrong."),
            ]);
        }

        foreach(json_decode($request->refund_items ?? '[]') as $refund_item){
            $item = $order->orderDetails->firstWhere('id',$refund_item->order_detail_id);
            if($refund_item->status && $refund_item->quantity > $item->quantity){
                return response()->json([
                    'success' => false,
                    'message' => translate("You can't request more than ordered quantity")
                ]);
            }
        }
        
        $amount = 0;
        foreach(json_decode($request->refund_items ?? '[]') as $refund_item){
            if($refund_item->status){
                $item = $order->orderDetails->firstWhere('id',$refund_item->order_detail_id);
                $amount += $refund_item->quantity * ($item->price + $item->tax);
            }
        }

        $attachments = [];
        if($request->hasFile('attachments')){
            foreach($request->file('attachments') as $key => $attachment){

                $upload = new Upload;
                $upload->file_original_name = null;

                $arr = explode('.', $attachment->getClientOriginalName());

                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                $upload->file_name = $attachment->store('uploads/all');
                $upload->user_id = $user->id;
                $upload->extension = $attachment->getClientOriginalExtension();
                $upload->type = 'image';
                $upload->file_size = $attachment->getSize();
                $upload->save();

                array_push($attachments, $upload->id);
            }
        }


        $refund_request =  new RefundRequest();
        $refund_request->order_id = $order->id;
        $refund_request->user_id = $order->user_id;
        $refund_request->shop_id = $order->shop_id;
        $refund_request->amount = $amount;
        $refund_request->reasons = $request->refund_reasons ? json_encode(explode(',',$request->refund_reasons)) : '[]';
        $refund_request->refund_note = $request->refund_note;
        $refund_request->attachments = implode(",",$attachments);
        $refund_request->save();
        
        foreach(json_decode($request->refund_items ?? '[]') as $key => $refund_item){
            if($refund_item->status){
                $refund_request_item =  new RefundRequestItem();
                $refund_request_item->refund_request_id = $refund_request->id;
                $refund_request_item->order_detail_id = $refund_item->order_detail_id;
                $refund_request_item->quantity = $refund_item->quantity;
                $refund_request_item->save();
            }
        }

        OrderUpdate::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'note' => 'Refund request created.',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => translate('Your request has been submitted successfully')
        ]);
         
    }
}