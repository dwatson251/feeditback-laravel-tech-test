<?php

namespace App\Domain\Entity\Movie;

/**
 * @see https://www.independentcinemaoffice.org.uk/advice-support/useful-exhibitor-resources/classification-censorship-and-film-certificates/
 */
enum SuitabilityRating
{
    case BBFC_U;
    case BBFC_PG;
    case BBFC_12A;
    case BBFC_12;
    case BBFC_15;
    case BBFC_18;
    case BBFC_R18;
}
