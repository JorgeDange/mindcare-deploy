<?php

return [
    'bank' => [
        'iban' => env('BANK_IBAN', 'AO06 0000 0000 0000 0000 0'),
        'holder' => env('BANK_HOLDER', 'MindCare Lda'),
        'account' => env('BANK_ACCOUNT_NUMBER'),
        'swift' => env('BANK_SWIFT'),
    ],

    'payment_methods' => [
        'Transferência Bancária (IBAN)',
        'Referência Multicaixa',
        'TPA na Clínica',
    ],
];
