# Ramblin' Reck Club website

Member site for the Ramblin' Reck Club at Georgia Tech: the points competition,
family standings, event calendar, and the probate T Plan tracker.

## Stack

Plain PHP 8, no framework. Bootstrap 4 (`data-toggle`, `custom-select`), PDO with
prepared statements, MySQL. Pages are top-to-bottom PHP with HTML below, sharing
`partials/` for head, header, footer and scripts. There is no build step - edit a
file, upload it, done.

`match()` is used in `points.php` and `events.php`, so **PHP 8 is required**.

## Where it runs

| | |
|---|---|
| Site | `reckclub.org` |
| Host | `web-plesk51.oit.gatech.edu` (130.207.49.9) - Georgia Tech OIT Plesk |
| Web root | `~/httpdocs` (Plesk convention, not `public_html`) |
| Panel | `https://web-plesk51.oit.gatech.edu:8443` |
| Database | `reck_club` on `reckclub.org:3306` |

Pushing to GitHub is **not** deploying. Code reaches the server separately -
check with the site admins how (Plesk File Manager, SFTP, or a pull on the server).

### Database accounts

`reck_readonly` for anything read-only, `external` when writes are needed.
`database_connect.php` holds the app's own credentials in plain text and is
tracked in git - worth moving to the existing `.env` pattern at some point.

Take a backup before any schema change or bulk update:

```bash
mysqldump -h reckclub.org -P 3306 -u reck_readonly -p --single-transaction --no-tablespaces reck_club > ~/reck_club_$(date +%F).sql
```

`--no-tablespaces` matters: without it a read-only user is refused for lacking
the PROCESS privilege. Verify the dump ends with `-- Dump completed on ...`.

## Schema

| Table | Notes |
|---|---|
| `Member` | `status` enum: probate / member / social / alumni / faculty. Role flags `isAdmin`, `isVP`, `isSecretary`, `isTreasurer`, `isEventAdmin`, `isProbateGuide`. `reckerPair` is a memberID (the RP). `memberPoints` and the four `*EventCount` columns are **cached**, not truth. |
| `Event` | Date is three columns - `dateYear`, `dateMonth`, `dateDay` - not a DATE. `eventName` is **varchar(32)**. `type` enum: mandatory / sports / social / work. That enum is the *only* categorisation the schema offers. |
| `AttendsEvent` | The permanent attendance record. A member row has `memberID`; a family-event row has `memberID NULL` and `familyID` set. |
| `Family` | 8 families. `familyPoints` is cached. |
| `ProbateTEntry` | Self-checked T Plan items, one row per completion. `withMemberID` is who a hangout was with. |
| `ProbateTOverride` | Forces an event to count, or not count, for one T requirement. |

`AttendsEvent` is never filtered on write, so attendance history is permanent.
Only the cached totals get recomputed.

## The points system

Points are **derived**, never accumulated. Every scoring query filters to the
current semester:

```sql
(MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') <= CURDATE()
```

Spring is Jan 1 - Jul 31, Fall is Aug 1 - Dec 31, and it flips automatically.
**This fragment is copy-pasted in about 12 places** across `points.php`,
`updatePoints.php`, `events.php`, `allAttended.php` and `recalculatePointsx.php`.
Change one, change all of them.

Flow: an event admin creates an event, a member ticks it off on `points.php` or
`events.php`, `updatePoints.php` writes `AttendsEvent` and recomputes that
member's total and their family's. `recalculatePointsx.php` (Manage Site ->
Recalculate Points) does the same for everyone.

`familyPoints` = sum of non-alumni members' `memberPoints`.

## Landmines

**`resetPointsx.php` runs `DELETE FROM Event`.** Never. The Manage Site page says
"use literally never".

**`revertDatabasex.php` drops 13 live tables** before restoring from `_bkup`
copies, and `CREATE TABLE ... LIKE` does not carry foreign keys - a revert
silently degrades the schema.

**Recalculate Points zeroes everyone if the current window has no events.** That
is arithmetically correct for a fresh semester but looks like catastrophic data
loss. Enter the semester's events first.

**Two conflicting family-points formulas.** `updatePoints.php` and
`recalculatePointsx.php` use a windowed sum; `updateFamilies.php` and
`updateFamilyEvents.php` still use an older unwindowed query that also adds
family-event points. Editing families or assigning a family event makes all 8
totals jump to all-time sums until a member update drags them back.
**Still unfixed** - it needs a decision on whether family events should count.

**`editFamilies.php` and `updateFamilies.php` only handle families 1-4**, but
there are 8. Families 5-8 cannot be renamed or have members reassigned there.

**Many `AttendsEvent` rows are orphans**, pointing at events no longer in
`Event`. Event IDs were renumbered at some point - see the comment in
`allTimeEvents.php`. All-time counts include rows whose events are gone.

## The probate T Plan tracker

| File | Role |
|---|---|
| `tplans/<semester>.php` | The plan as data - every requirement, its wording, how it is counted |
| `lib/tplan.php` | Evaluator, plus `tplan_guard()` for access |
| `myTs.php` | A probate's dashboard. Nav tab "My Ts" |
| `tPlan.php` | Read-only walkthrough of the plan. Nav tab "The T Plan" |
| `probateTs.php` | Guide roster. Nav tab "Probate Ts" |
| `updateTs.php` | Writes self-checked entries |
| `docs/T-PLAN.md` | **Read this before writing a new semester's plan** |

Requirements are either `auto` (matched against event names and types, so a
member ticking an event off updates their dashboard for free) or `self` (ticked
by the probate, honor system, matching how points already work).

**Match on keyword AND type.** `football` alone pulls in "IM Flag Football" and
"Tech Green Football PMS"; `football` + `type=mandatory` gives exactly the home
games. This is the single biggest source of wrong numbers.

### Access

`tplan_guard()` allows probates, `isProbateGuide` and `isAdmin`; everyone else is
sent to `points.php` and sees no T nav links. A probate asking for another
probate's dashboard by id lands on their own. Guides and admins can read any
dashboard but cannot tick anything - `updateTs.php` only ever writes to
`$_SESSION['memberID']`.

Current guides: Harrison Burnside (1206), Katie Park (1209).

## Conventions and gotchas

**Line endings are mixed.** `families.php` is CRLF; most newer files are LF.
`core.autocrlf` is `input`, which rewrites CRLF on commit and turns a 9-line
change into a 755-line diff. When touching a CRLF file:

```bash
git -c core.autocrlf=false add families.php
git -c core.autocrlf=false commit
```

Check the diffstat afterwards - if it is far bigger than your edit, that is why.

**Escape output.** `familyName` is written straight from `$_POST` in
`updateFamilies.php`, so anything echoing it needs `htmlspecialchars()`. Member
ids reaching an href should be cast to int.

**Adding a role column takes four edits, not one.** The column, then
`auth/auth_login.php` (the only place session roles are assigned - both the
password and OIDC logins funnel through `successfulLogin()`), then
`set_session_vars_full.php` and `set_session_vars_short.php`. Guard new session
reads with `isset()` so existing sessions do not fatal.

**The repo lives in iCloud Drive**, which causes intermittent
`Operation not permitted` failures in git (macOS TCC plus file eviction). If git
starts failing on `getcwd()`, grant the terminal Full Disk Access and relaunch,
or move the repo out of iCloud.

## Testing locally

There is a local MySQL with a `reck_club` database and a `reck`/`burdell` user
matching `database_connect.php`, so the site runs locally as-is. To test against
current production data, load a dump into a separate database and point a local
copy of `database_connect.php` at it rather than overwriting the local one.

Lint before committing - there is no test suite:

```bash
php -l <file>
```
