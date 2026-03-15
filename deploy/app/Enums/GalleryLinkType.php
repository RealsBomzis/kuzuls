<?php

namespace App\Enums;

enum GalleryLinkType: string
{
    case Pasakumi = 'pasakumi';
    case Projekti = 'projekti';
    case Jaunumi = 'jaunumi';
    case Nav = 'nav';
}