# Setting up a new semester's T Plan

Everything about the T Plan lives in one file: `tplans/<semester>.php`. To run a new
semester, hand Claude the new T Plan document and this file, and ask it to write
`tplans/spring-2027.php`. Nothing else needs to change.

Point the pages at the new plan by editing the one line in `myTs.php` and
`probateTs.php`:

```php
$plan = tplan_load('spring-2027');
```

Old plans stay on disk, so a past semester can still be viewed.

---

## The shape of a plan file

The file returns one big array:

```php
return [
  'key'      => 'fall-2026',                 // must match the filename
  'name'     => 'Fall 2026 Probate T Plan',
  'deadline' => '2026-11-16 12:00:00',       // drives the days-left counter
  'general'  => [ ...requirements... ],      // the always-on requirements
  'mandatory'=> [ ...Ts... ],                // every one of these must be finished
  'elective' => ['need' => 3, 'ts' => [...]],// finish any N of these
  'makeup'   => ['max' => 5, 'ts' => [...]], // at most N of these may be used
];
```

## A T

```php
[
 'key'   => 'reck-events',            // stable id, never reuse across meanings
 'name'  => 'Reck Club Events T',
 'blurb' => 'One sentence shown under the title.',
 'choose'=> 3,                        // OPTIONAL: finish 3 of the parts, not all
 'parts' => [ ...requirements... ],
]
```

Leave `choose` out when every part is required. Use it for things worded
"complete THREE of the following".

## A requirement (a "part")

```php
[
 'key'   => 'fball-games',
 'label' => 'Attend all home football games',
 'need'  => 6,                        // how many are required
 'mode'  => 'auto',                   // 'auto' or 'self'
 'hint'  => 'Colorado, UTK, Mercer…',  // OPTIONAL grey helper line
 'match' => [ ... ],                  // only for mode 'auto'
]
```

### `mode` — where the number comes from

| mode | meaning |
|---|---|
| `auto` | Counted from events the probate already checked off on the points site. They do nothing extra. |
| `self` | The probate ticks it themselves. Honor system, same as points. |

Use `auto` whenever the thing is an event on the calendar. Use `self` for
anything off-calendar: duties, hangouts, intramural games, Reckognitions
received, make-up Ts.

### `match` — how auto requirements find events

```php
'match' => [
  'type' => ['work','social'],        // event types allowed
  'any'  => ['flag fold','gtif'],     // matches if the name contains ANY of these
  'all'  => ['reck','wash'],          // matches only if the name contains ALL
  'not'  => ['hoco','homecoming'],    // never match if the name contains these
]
```

All comparisons are lowercase substring matches against `eventName`. Every key is
optional, but include `type` wherever you can — it prevents most false matches.

**Always set `type`.** Matching `football` alone pulls in "IM Flag Football" and
"Tech Green Football PMS"; adding `'type' => ['mandatory']` gives exactly the home
games. This is the single biggest source of wrong numbers.

**Write patterns short and lowercase.** `flag fold` catches "Flag Folding",
"Flag folding for game", and "Gardner-Webb Flag Folding!" while correctly skipping
"IM Flag Football". `flag` alone would catch all of them.

**Check for near-misses.** `reck wash` is right; `reck` alone would also match
"Reck-it-Ralph", "Reckaversary" and "Reck the Stress".

**Add spelling variants.** People write "WAHO" far more often than
"Waffle House", so that requirement needs `['waho','waffle house']`.

### `buckets` — "do each of these at least once"

For a requirement like *six football prep events, and each type at least once*:

```php
'need'    => 6,
'buckets' => [
  'Waffle House' => ['waho','waffle house'],
  'Flag Folding' => ['flag fold'],
  'GTIF'         => ['gtif'],
  'Reck Washing' => ['reck wash'],
],
'each_at_least' => 1,
```

Only events falling into a bucket count toward `need`, and the requirement stays
incomplete while any bucket is under `each_at_least` — even at 6 of 6. The
dashboard names the missing bucket in red.

## Make-up Ts

Same shape as a part, plus a `name` and `blurb`:

```php
['key'=>'bigbuzz','name'=>'Big Buzz Wrangler T','need'=>3,'mode'=>'self',
 'blurb'=>'Three Big Buzz setups or take-downs'],
```

`'max' => 5` caps how many can be used.

---

## After writing a new plan

1. **Run the pattern check.** For each `auto` requirement, look at what it
   actually matched last semester:

   ```sql
   SELECT type, eventName FROM Event
   WHERE dateYear=2026 AND dateMonth BETWEEN 8 AND 12
     AND LOWER(eventName) LIKE '%flag fold%';
   ```

   If it returns things that shouldn't count, tighten the pattern or add `not`.

2. **Open one probate's dashboard** and read the numbers against what you know is
   true for them. A pattern that matches nothing shows as `0/6` and is easy to miss.

3. **Check the double-count warning.** The dashboard lists any event counted in
   two places. Some overlap is expected — "HOCO GTIF" is legitimately both a
   Homecoming event and a GTIF — and the guides resolve it. Nothing is blocked.

## Things the system deliberately does not do

- **It does not block double-counting.** It warns. The FAQ says one event can't
  satisfy two components, but the guides decide case by case.
- **It does not verify self-checked items.** Honor system, matching how points
  already work. `rules.php` already covers points fraud.
- **It does not know who granted a Reckognition.** The probate logs it themselves
  with a note saying who.

## What is stored

Two tables. Everything else is derived at page load from `AttendsEvent`.

```sql
ProbateTCheck    (memberID, planKey, reqKey, n, note, updatedAt)
ProbateTOverride (memberID, planKey, reqKey, eventID, action)
```

`ProbateTCheck` holds self-checked counts. `ProbateTOverride` lets a probate force
an event to count, or stop counting, for one requirement — the escape hatch for
when name matching gets it wrong.
