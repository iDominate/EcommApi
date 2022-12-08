<?php

namespace App\Enums;

enum OrderStatus: int {
    case Paid = 0;
    case Preparing = 1;
    case Shipping = 2;
    case Shipped = 3;
    case Delived = 4;

}