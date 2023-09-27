<?php

namespace SFW;

/**
 * Page-by-page navigator.
 */
class Paginator
{
    /**
     * Total number of entries (>= 1) (copied from arguments).
     */
    public int $totalEntries;

    /**
     * Number of entries per page (>= 1) (copied from arguments).
     */
    public int $entriesPerPage;

    /**
     * Number of pages per set (>= 1) (copied from arguments).
     */
    public int $pagesPerSet;

    /**
     * Total number of pages (>= 1).
     */
    public int $totalPages;

    /**
     * Current number of page (>= 1) (copied from arguments and corrected).
     */
    public int $currentPage;

    /**
     * Previous number of page (>= 1 or false).
     */
    public int|false $prevPage;

    /**
     * Next number of page (>= 1 or false).
     */
    public int|false $nextPage;

    /**
     * Start position of current set (>= 1).
     */
    public int $startOfSet;

    /**
     * End position of current set (>= 1).
     */
    public int $endOfSet;

    /**
     * Numbers of set (One or more numbers in array).
     */
    public array $numbersOfSet = [];

    /**
     * Nearest page number of the previous set (>= 1 or false).
     */
    public int|false $pageOfPrevSet;

    /**
     * Nearest page number of the next set (>= 1 or false).
     */
    public int|false $pageOfNextSet;

    /**
     * Starting position of the slice (>= 0).
     */
    public int $startOfSlice;

    /**
     * Ending position of the slice (>= 0).
     */
    public int $endOfSlice;

    /**
     * Length of the slice (>= 1).
     */
    public int $lengthOfSlice;

    /**
     * Doing all calculations and storing at properties.
     */
    public function __construct(
        int $totalEntries,
        int $entriesPerPage,
        int $pagesPerSet,
        int $currentPage
    ) {
        // {{{ statistics

        $this->totalEntries = $totalEntries;

        $this->entriesPerPage = $entriesPerPage;

        $this->pagesPerSet = $pagesPerSet;

        $this->totalPages = ceil($this->totalEntries / $this->entriesPerPage);

        // }}}
        // {{{ pages control

        $this->currentPage = $currentPage;

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        } elseif ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }

        $this->prevPage = $this->currentPage - 1;

        if ($this->prevPage < 1) {
            $this->prevPage = false;
        }

        $this->nextPage = $this->currentPage + 1;

        if ($this->nextPage > $this->totalPages) {
            $this->nextPage = false;
        }

        // }}}
        // {{{ pages set control

        $this->startOfSet = $this->pagesPerSet * floor(($this->currentPage - 1) / $this->pagesPerSet) + 1;

        $this->endOfSet = $this->startOfSet + $this->pagesPerSet - 1;

        if ($this->endOfSet > $this->totalPages) {
            $this->endOfSet = $this->totalPages;
        }

        $this->numbersOfSet = range($this->startOfSet, $this->endOfSet);

        $this->pageOfPrevSet = $this->startOfSet - 1;

        if ($this->pageOfPrevSet < 1) {
            $this->pageOfPrevSet = false;
        }

        $this->pageOfNextSet = $this->endOfSet + 1;

        if ($this->pageOfNextSet > $this->totalPages) {
            $this->pageOfNextSet = false;
        }

        // }}}
        // {{{ slice params

        $this->startOfSlice = ($this->currentPage - 1) * $this->entriesPerPage;

        $this->endOfSlice = $this->startOfSlice + $this->entriesPerPage - 1;

        if ($this->endOfSlice > $this->totalEntries - 1) {
            $this->endOfSlice = $this->totalEntries - 1;
        }

        $this->lengthOfSlice = $this->endOfSlice - $this->startOfSlice + 1;

        // }}}
    }

    /**
     * Returns all parameters in array with snake cased keys.
     */
    public function toArray(): array
    {
        return array_combine(
            [
                'total_entries',
                'entries_per_page',
                'pages_per_set',
                'total_pages',
                'current_page',
                'prev_page',
                'next_page',
                'start_of_set',
                'end_of_set',
                'numbers_of_set',
                'page_of_prev_set',
                'page_of_next_set',
                'start_of_slice',
                'end_of_slice',
                'length_of_slice',
            ], (array) $this
        );
    }
}
