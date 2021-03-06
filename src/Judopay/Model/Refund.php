<?php

namespace Judopay\Model;

use \Judopay\DataType;

class Refund extends \Judopay\Model
{
    protected $resourcePath = 'transactions/refunds';
    protected $validApiMethods = array('all', 'create');
    protected $attributes = array(
    'receiptId' => DataType::TYPE_STRING,
    'yourPaymentReference' => DataType::TYPE_STRING,
    'amount' => DataType::TYPE_FLOAT
    );
    protected $requiredAttributes = array(
      'receiptId',
      'yourPaymentReference',
      'amount'
    );
}
