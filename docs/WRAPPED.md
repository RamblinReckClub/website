# Reck Club Wrapped

A member's calendar year in cards: events, their people, the mix of event types, their
smallest events, their rhythm through the year and their biggest day.

| File | Role |
|---|---|
| `lib/wrapped.php` | Works everything out, plus who may see it and `wrapped_guard()` |
| `wrapped.php` | The page, and the admin controls at the top of it |
| `updateWrapped.php` | Release, send, and take back. Admins only |
| `partials/wrappedBanner.php` | The "your year is ready" banner on `points.php` |

## Who can see it

Until an admin does something, only `isAdmin` can open `wrapped.php`, and the link sits
in the Admin menu. An admin can look at any member and any year.

There are two ways to put it in front of members, both from the bar at the top of
`wrapped.php`:

- **Release to everyone** - every member gets their own page for that year.
- **Send to one member** - only the member being viewed gets theirs.

Either way the member sees a banner at the top of their points page (where login lands)
and a Wrapped tab, for `WRAPPED_SHOW_DAYS` days - 5. After that both disappear and the
page is admin-only again. **Release again** / **Send again** restarts the 5 days;
**Take it back** ends it early. A member only ever sees their own page.

## The two tables

The numbers are never stored; only who may see them. Create these on the server before
using the buttons (without them the page still works for admins, and the buttons report
that the tables are missing):

```sql
CREATE TABLE WrappedRelease (
	year       SMALLINT NOT NULL PRIMARY KEY,
	releasedAt DATETIME NOT NULL,
	releasedBy INT NULL
);

CREATE TABLE WrappedSend (
	memberID INT NOT NULL,
	year     SMALLINT NOT NULL,
	sentAt   DATETIME NOT NULL,
	sentBy   INT NULL,
	PRIMARY KEY (memberID, year)
);
```

Neither is one of the tables `backupDatabasex.php` and `revertDatabasex.php` handle, so
a revert leaves them alone.

## Changing the wording

The headline for the mix card and the sign-off are picked by rule in
`wrapped_persona()` and `wrapped_thanks()`. Everything else is written in `wrapped.php`
next to the card it belongs to.
