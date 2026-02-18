<?php

namespace Payroc\Attachments\Types;

enum UploadToProcessingAccountAttachmentsRequestAttachmentType: string
{
    case BankingEvidence = "bankingEvidence";
    case QuestionnairesAndLicenses = "questionnairesAndLicenses";
    case MerchantStatements = "merchantStatements";
    case TaxDocuments = "taxDocuments";
    case MpaOrAmendment = "mpaOrAmendment";
    case ProofOfBusiness = "proofOfBusiness";
    case FinancialStatements = "financialStatements";
    case PersonalIdentification = "personalIdentification";
    case Other = "other";
}
