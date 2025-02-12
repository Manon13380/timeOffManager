<?php

namespace App\Message;

final class LeaveRequestMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     public function __construct(
        public int $id,
     ) {
 }
}
