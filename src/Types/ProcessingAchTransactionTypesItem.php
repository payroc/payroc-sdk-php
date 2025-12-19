<?php

namespace Payroc\Types;

enum ProcessingAchTransactionTypesItem: string
{
    case PrearrangedPayment = "prearrangedPayment";
    case CorpCashDisbursement = "corpCashDisbursement";
    case TelephoneInitiatedPayment = "telephoneInitiatedPayment";
    case WebInitiatedPayment = "webInitiatedPayment";
    case Other = "other";
}
