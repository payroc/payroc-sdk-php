<?php

namespace Payroc\Boarding\Contacts\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\Contact;

class UpdateContactsRequest extends JsonSerializableType
{
    /**
     * @var Contact $body
     */
    public Contact $body;

    /**
     * @param array{
     *   body: Contact,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
