<?php

namespace Payroc\Types;

enum TransactionResultEbtType: string
{
    case CashPurchase = "cashPurchase";
    case CashPurchaseWithCashback = "cashPurchaseWithCashback";
    case FoodStampPurchase = "foodStampPurchase";
    case FoodStampVoucherPurchase = "foodStampVoucherPurchase";
    case FoodStampReturn = "foodStampReturn";
    case FoodStampVoucherReturn = "foodStampVoucherReturn";
    case CashBalanceInquiry = "cashBalanceInquiry";
    case FoodStampBalanceInquiry = "foodStampBalanceInquiry";
    case CashWithdrawal = "cashWithdrawal";
}
