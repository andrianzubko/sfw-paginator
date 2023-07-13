# SFW Paginator

This class intended for organization of paginal navigation on some data. Basically intended for construction of paginal navigation panels on web sites.

## Installation

```sh
composer require andrianzubko/sfw-paginator
```

## Usage

```php

// Making all calculations and storing results at class properties.
//
// All arguments are required and must contains only integer numbers.
$pg = new \SFW\Paginator(
    $totalEntries,   // total number of entries (>= 1)
    $entriesPerPage, // number of entries per page (>= 1)
    $pagesPerSet,    // number of pages per set (>= 1)
    $currentPage     // current number of page
);

// Get some property
$pg->totalEntries;

// or get all in array with keys in snake case
$pg->toArray()['total_entries'];

```
## Properties

### Slice params:

$pg->startOfSlice - start position of the slice (>= 0)

$pg->endOfSlice - end position of the slice (>= 0)

$pg->lengthOfSlice - length of the slice (>= 1)

### Statistics:

$pg->totalEntries - total number of entries (>= 1) (copied from arguments)

$pg->entriesPerPage - number of entries per page (>= 1) (copied from arguments)

$pg->pagesPerSet - number of pages per set (>= 1) (copied from arguments)

### Pages control:

$pg->totalPages - total number of pages (>= 1)

$pg->currentPage - current number of page (>= 1) (corrected)

$pg->prevPage - previous number of page (>= 1 or false)

$pg->nextPage - next number of page (>= 1 or false)

### Pages set control:

$pg->startOfSet - start position of current set (>= 1)

$pg->endOfSet - end position of current set (>= 1)

$pg->pageOfPrevSet - nearest page number of the previous set (>= 1 or false)

$pg->pageOfNextSet - nearest page number of the next set (>= 1 or false)

$pg->numbersOfSet - numbers of set (one or more numbers in array)

## Examples

### Simple

```
             <-- previous page | next page -->
                   /                   \
           $pg->prevPage            $pg->nextPage
```

### Advanced

```
                    $pg->currentPage
                            |
        $pg->prevPage       |           $pg->nextPage
                \           |                /
        <<       <       6 [7] 8 9 10       >       >>
        /               /           \                \
$pg->pageOfPrevSet     /             \    $pg->pageOfNextSet
                      /               \
            $pg->startOfSet       $pg->endOfSet
                     |                 |
                    [ $pg->numbersOfSet ]
```

### Statistics

```
                $pg->totalPages
               /   $pg->totalEntries
Total pages: 20   /
Total records: 200
Shown from 61 to 70 records
             \     \
              \     $pg->startOfSlice + 1
               $pg->endOfSlice + 1
```

## Notes

- Most simple way to check, needs to show navigation panel or not, is checking $pg->totalPages property. Needs only, if this property more then 1.

- $pg->prevPage, $pg->nextPage, $pg->pageOfPrevSet and $pg->pageOfNextSet properties must be checked for false value before using.
