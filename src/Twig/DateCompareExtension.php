<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use \DateTime;

class DateCompareExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('has_date_diff', [$this, 'hasDateDiff'])
        ];
    }

    public function hasDateDiff(DateTime $oldDate, DateTime $newDate)
    {
        $diff = $oldDate->diff($newDate);
        $days = $diff->days;

        if ($days > 0) {
            return true;
        }

        return false;
    }
}