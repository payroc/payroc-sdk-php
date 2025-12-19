<?php

namespace Payroc\Types;

enum IpAddressType: string
{
    case Ipv4 = "ipv4";
    case Ipv6 = "ipv6";
}
