<?php

namespace App\Enums;

enum TypeEnum: string
{
  case AGGREGATE = 'aggregate';
  case DECILE = 'decile';
  case RFM = 'rfm';
}
