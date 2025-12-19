<?php

namespace Payroc\Types;

enum DeviceModel: string
{
    case BbposChp = "bbposChp";
    case BbposChp2X = "bbposChp2x";
    case BbposChp3X = "bbposChp3x";
    case BbposRambler = "bbposRambler";
    case BbposWp = "bbposWp";
    case BbposWp2 = "bbposWp2";
    case BbposWp3 = "bbposWp3";
    case GenericCtlsMsr = "genericCtlsMsr";
    case GenericMsr = "genericMsr";
    case IdtechAugusta = "idtechAugusta";
    case IdtechMinismart = "idtechMinismart";
    case IdtechSredkey = "idtechSredkey";
    case IdtechVp3300 = "idtechVp3300";
    case IdtechVp5300 = "idtechVp5300";
    case IdtechVp6300 = "idtechVp6300";
    case IdtechVp6800 = "idtechVp6800";
    case IngenicoAxiumDx4000 = "ingenicoAxiumDx4000";
    case IngenicoAxiumDx8000 = "ingenicoAxiumDx8000";
    case IngenicoAxiumEx8000 = "ingenicoAxiumEx8000";
    case IngenicoIct220 = "ingenicoIct220";
    case IngenicoIpp320 = "ingenicoIpp320";
    case IngenicoIpp350 = "ingenicoIpp350";
    case IngenicoIuc285 = "ingenicoIuc285";
    case IngenicoL3000 = "ingenicoL3000";
    case IngenicoL7000 = "ingenicoL7000";
    case IngenicoS2000 = "ingenicoS2000";
    case IngenicoS3000 = "ingenicoS3000";
    case IngenicoS4000 = "ingenicoS4000";
    case IngenicoS5000 = "ingenicoS5000";
    case IngenicoS7000 = "ingenicoS7000";
    case PaxA80 = "paxA80";
    case PaxA920 = "paxA920";
    case PaxA920Pro = "paxA920Pro";
    case PaxE500 = "paxE500";
    case PaxE700 = "paxE700";
    case PaxE800 = "paxE800";
    case PaxIm30 = "paxIm30";
    case Uic680 = "uic680";
    case UicBezel8 = "uicBezel8";
}
