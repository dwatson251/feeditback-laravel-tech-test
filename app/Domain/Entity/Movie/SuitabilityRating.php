<?php

namespace App\Domain\Entity\Movie;

/**
 * @see https://www.independentcinemaoffice.org.uk/advice-support/useful-exhibitor-resources/classification-censorship-and-film-certificates/
 */
enum SuitabilityRating: string
{
    case BBFC_U = 'U';
    case BBFC_PG = 'PG';
    case BBFC_12A = '12A';
    case BBFC_12 = '12';
    case BBFC_15 = '15';
    case BBFC_18 = '18';
    case BBFC_R18 = 'R18';
}
