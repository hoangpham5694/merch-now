<?php

const DESIGN_STATUSES = [
  'ok' => 'Ok',
  'danger' => 'Danger',
  'close' => 'Close',
];
const DESIGN_MODES= ['trend' => 'Trend', 'niche' => 'Niche','tm' => 'TM','niche-trend'=>'Niche - Trend'];
const SHIRT_STATUSES = [
    'review' => 'Review',
    'close' => 'Close',
    'wait' => 'Wait',
    'live' => 'Live',
    'reject' => 'Reject',
];
const SHIRT_TYPES=[
  'standard'=>'Standard T-Shirt',
  'premium'=>'Premium T-Shirt',
  'sweat'=>'Sweatshirt',
  'long-sleeve' => 'Long Sleeve T-Shirt',
  'hoodie' => 'Pullover Hoodie',
];
const VPS_SERVICES=['aws' => 'Amazon', 'vultr' => 'Vultr','gcloud' => 'Google Cloud'];
const ACCOUNT_STATUSES=['alive'=>'Alive','die'=>'Die'];
const ACCOUNT_MODES = ['trend' => 'Trend', 'niche' => 'Niche','tm' => 'TM'];
const LIST_BROWSERS = [
  'chrome'=>'Chrome',
  'firefox'=>'FireFox',
  'edge'=>'Edge',
  'coccoc'=>'Coc Coc',
  'ie'=>'Interner Explorer'
];

const SPECIAL = [
  'yes' => 'Special',
  'no' => 'Normal'
];
function ResponseData($statusCode, $message, $data = [])
{
    if($statusCode == 200){
        $reponse_data = [
            'success' => [
                'status' => $statusCode,
                'message' => $message
            ]
        ];
    } else {
        $reponse_data = [
            'error' => [
                'status' => $statusCode,
                'message' => $message
            ]
        ];
    }
    if(is_array($data) && !empty($data)){
        $reponse_data['success'] = array_merge($reponse_data['success'], $data);
    }
    return json_encode($reponse_data);
}
