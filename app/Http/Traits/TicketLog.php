<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait TicketLog
{
    public function ticketLog(Request $request,$ticket_id){
        return \App\Models\TicketLog::create([
            'user_id' => $request->get('user_id'),
            'ticket_id' => $ticket_id,
            'route_name' => $request->route()->getName(),
            'log' => json_encode($request->all()),
            'info' => json_encode($request->header())
        ]);
    }
}
