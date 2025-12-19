<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\EbtDetails;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Electronic Benefit Transfer (EBT) transaction.
 */
class EbtDetailsWithVoucher extends JsonSerializableType
{
    use EbtDetails;

    /**
     * @var ?Voucher $voucher
     */
    #[JsonProperty('voucher')]
    public ?Voucher $voucher;

    /**
     * @param array{
     *   benefitCategory: value-of<EbtDetailsBenefitCategory>,
     *   withdrawal?: ?bool,
     *   voucher?: ?Voucher,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->benefitCategory = $values['benefitCategory'];
        $this->withdrawal = $values['withdrawal'] ?? null;
        $this->voucher = $values['voucher'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
