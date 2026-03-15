<?php

namespace App\Enums;

enum ContentType: string
{
    case Pasakumi = 'pasakumi';
    case Projekti = 'projekti';
    case Jaunumi = 'jaunumi';
    case Galerijas = 'galerijas';
    case Lapas = 'lapas';
    case KontaktZinojumi = 'kontakt_zinojumi';
    case Lietotaji = 'lietotaji';
    case Cits = 'cits';
}