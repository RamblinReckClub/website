<?php
// Fall 2026 Probate T Plan.
// See docs/T-PLAN.md for what every key means and how to write a new semester.
//
//   label  short name shown on the dashboard row
//   desc   full explanation, shown on the T Plan guide page and under the row
//   mode   'auto' (counted from checked-off events) or 'self' (probate ticks it)
//   cap    this part is a ceiling, not a floor - it never blocks completion
//   sum    have = the capped totals of the named sibling parts

return [
'key'      => 'fall-2026',
'name'     => 'Fall 2026 Probate T Plan',
'start'    => '2026-08-25 00:00:00',
'deadline' => '2026-11-16 12:00:00',
'intro'    => 'Four mandatory Ts, any three Elective Focus Ts, and up to five make-up Ts to cover what you miss. Nothing here can be double-counted: one event satisfies one component.',

'general' => [
	['key'=>'gen-20','label'=>'20 non-mandatory events','need'=>20,'mode'=>'auto',
	 'match'=>['type'=>['sports','social','work']],
	 'desc'=>'Attend twenty events this semester that are not general meetings. Sports, socials and work events all count, and this runs alongside every other T.'],
	['key'=>'gen-log','label'=>'Probate log','need'=>1,'mode'=>'self',
	 'desc'=>'Write and hand in your probate log at the end of the semester. Tick this once it is submitted.'],
	['key'=>'gen-3p','label'=>'Party, Prank & Project','need'=>3,'mode'=>'self',
	 'hint'=>'Party already complete',
	 'desc'=>'Help plan and run all three of the 3Ps. These span Spring and Fall, and the Party is already done.'],
],

'mandatory' => [
[
'key'=>'reck-events','name'=>'Reck Club Events T','accent'=>'navy',
'blurb'=>'Experience the mandatory events that Reck Club chairs and committees put on.',
'parts'=>[
	['key'=>'hoco4','label'=>'Four Homecoming events','need'=>4,'mode'=>'auto',
	 'match'=>['any'=>['hoco','homecoming','tricycle','team rrc'],'type'=>['work','social','sports']],
	 'desc'=>'Four non-mandatory Homecoming events. Team RRC events, event tabling and tricycle pickup all count. Extra ones past four can be counted as work events elsewhere in the plan.'],
	['key'=>'mini500','label'=>'Work Mini 500','need'=>1,'mode'=>'auto','match'=>['any'=>['mini 500']],
	 'desc'=>'Work a shift at the Mini 500 on Homecoming Friday.'],
	['key'=>'cakerace','label'=>'Work Freshman Cake Race','need'=>1,'mode'=>'auto',
	 'match'=>['any'=>['cake race','fcr ']],
	 'desc'=>'Work the Freshman Cake Race. Bib distribution and FCR tabling days count toward this.'],
	['key'=>'parade','label'=>'Work Ramblin\' Wreck Parade','need'=>1,'mode'=>'auto',
	 'match'=>['any'=>['wreck parade']],
	 'desc'=>'Work the Ramblin\' Wreck Parade on Homecoming Saturday morning.'],
	['key'=>'tnight','label'=>'T-Night and a T-Night duty','need'=>1,'mode'=>'self',
	 'hint'=>'Attendance is auto; the duty is yours to tick',
	 'desc'=>'Attend T-Night and work a duty while you are there. Your attendance comes off the points page on its own, but only you know whether you worked a duty.'],
	['key'=>'fball-games','label'=>'All home football games','need'=>6,'mode'=>'auto',
	 'match'=>['any'=>['football'],'type'=>['mandatory']],
	 'hint'=>'Colorado, UTK, Mercer, Duke, Boston College, Louisville',
	 'desc'=>'Attend every home game at Bobby Dodd before the deadline. Six fall inside the window. A planned absence, excused or not, is exactly what a make-up T is for.'],
	['key'=>'pregame','label'=>'One pre-game duty','need'=>1,'mode'=>'self',
	 'hint'=>'Assigned by Kaylie',
	 'desc'=>'Work one pre-game duty - pizza giveaways, selling scarves, and the like. Kaylie assigns these, so it will find you.'],
	['key'=>'flagduty','label'=>'Two Flag duties','need'=>2,'mode'=>'self',
	 'hint'=>'Assigned by Kaylie',
	 'desc'=>'Work two Flag Top or Flag Bottom duties across the season. Also assigned by Kaylie.'],
	['key'=>'fball-prep','label'=>'Six football prep events','need'=>6,'mode'=>'auto',
	 'match'=>['type'=>['work','social']],
	 'buckets'=>[
		'Waffle House' => ['waho','waffle house'],
		'Flag Folding' => ['flag fold'],
		'GTIF'         => ['gtif'],
		'Reck Washing' => ['reck wash'],
	 ],
	 'each_at_least'=>1,
	 'desc'=>'Six gameday prep events, and you must do each of the four kinds at least once unless you have a recurring commitment. Six of one kind does not finish this.'],
]],
[
'key'=>'exec-star','name'=>'Exec Involvement Star T','accent'=>'navy',
'blurb'=>'Stay involved with what exec members actually do. Earn any three of the five stars.',
'choose'=>3,
'parts'=>[
	['key'=>'star-di','label'=>'D&I Star','need'=>1,'mode'=>'self',
	 'desc'=>'Either lead and coordinate a club-wide D&I event with the D&I Chair, or attend two D&I events run by the chair or by other probates and members. A potluck, an activity built around your own background, or a presentation at a weekly meeting all work.'],
	['key'=>'star-subchair','label'=>'Sub-Chair Star','need'=>1,'mode'=>'self',
	 'desc'=>'Contribute consistently to a Fall subchair - Outreach, T-Night, Homecoming or Football.'],
	['key'=>'star-bylaws','label'=>'Bylaws Star','need'=>2,'mode'=>'self',
	 'desc'=>'Attend two Bylaws Committee meetings. Times to be announced.'],
	['key'=>'star-merch','label'=>'Merch Star','need'=>1,'mode'=>'self',
	 'desc'=>'Either get a merch design accepted - RRC designs go to the MALs, GT designs to the fundraising chair - or buy a MAL merch item.'],
	['key'=>'star-im','label'=>'Intramurals Star','need'=>1,'mode'=>'self',
	 'desc'=>'Either play in at least four Reck Club intramural games, or support at least five from the sideline. Playoff games count double, if we get there.'],
]],
[
'key'=>'spirit','name'=>'Spirit & Traditions T','accent'=>'gold',
'blurb'=>'Earn two Reckognitions from members for showing what the club is about.',
'parts'=>[
	['key'=>'reckog','label'=>'Two Reckognitions','need'=>2,'mode'=>'self',
	 'hint'=>'Log each one and who granted it',
	 'desc'=>'Any member can grant you a Reckognition for an exemplary Reck interaction, exceptional enthusiasm at a sporting event, an above-and-beyond impact in a position or committee, or real leadership on a Reck Club event. The site cannot see these, so log each one yourself with the name of who gave it.'],
]],
[
'key'=>'impact','name'=>'Important Impact T','accent'=>'gold',
'blurb'=>'Make a real mark on the club through one leadership opportunity.',
'choose'=>1,
'parts'=>[
	['key'=>'imp-social','label'=>'Social Host','need'=>1,'mode'=>'self',
	 'desc'=>'Host a large social for the club - twelve or more probates and members.'],
	['key'=>'imp-launch','label'=>'Initiative Launch','need'=>1,'mode'=>'self',
	 'desc'=>'Devise, plan and run a brand new Reck or work event.'],
	['key'=>'imp-passion','label'=>'Passion Project','need'=>1,'mode'=>'self',
	 'desc'=>'Plan and execute a project that leaves the club better than you found it.'],
	['key'=>'imp-subchair','label'=>'Sub-Chair Expansion','need'=>1,'mode'=>'self',
	 'desc'=>'Go beyond the annual expectations of your subchair with a meaningful new element to the role. Must be approved by the Chair or the Probate Guides.'],
]],
],

'elective' => ['need'=>3, 'ts'=>[
[
'key'=>'athletics','name'=>'Athletics Focus T','accent'=>'buzz',
'blurb'=>'Flex your Georgia Tech fandom across all the Fall sports.',
'parts'=>[
	['key'=>'ath6','label'=>'Six non-mandatory sporting events','need'=>6,'mode'=>'auto',
	 'match'=>['type'=>['sports']],
	 'desc'=>'Volleyball, basketball, road football, cross country, swim and dive, and club sports all count. Unlike the Social Focus T, road games do not count double here - this T is about the game you turned up to.'],
]],
[
'key'=>'friendship','name'=>'Friendship Focus T','accent'=>'buzz',
'blurb'=>'Spend real time with the best people on campus.',
'parts'=>[
	['key'=>'hangouts','label'=>'Eight distinct hangouts','need'=>8,'mode'=>'self',
	 'hint'=>'One per member; at most three with your RP',
	 'desc'=>'Eight separate one-on-one hangouts with members, outside of Reck Club events. No member can be counted twice, and at most three of the eight can be with your own RP. Pick who you were with and the site keeps you honest on both rules.'],
]],
[
'key'=>'social','name'=>'Social Focus T','accent'=>'buzz',
'blurb'=>'Fifteen socials, of which at least seven have to be non-PMS.',
'parts'=>[
	['key'=>'soc-nonpms','label'=>'Social events (non-PMS)','need'=>7,'mode'=>'auto',
	 'match'=>['type'=>['social'],'not'=>['pms']],
	 'desc'=>'At least seven of your fifteen socials must be something other than a PMS. Socials outside Atlanta - a sports road trip, a camping trip - count as two.'],
	['key'=>'soc-pms','label'=>'PMS events','need'=>8,'cap'=>8,'mode'=>'auto',
	 'match'=>['type'=>['social'],'any'=>['pms']],
	 'desc'=>'PMS events count toward the fifteen, but only eight of them can. Anything past eight still shows here but stops adding to your total. Planning a PMS counts as two events.'],
	['key'=>'soc-total','label'=>'Total social events','need'=>15,'mode'=>'auto',
	 'sum'=>['soc-nonpms','soc-pms'],
	 'desc'=>'Fifteen socials in total, counting every non-PMS plus up to eight PMS events. Probate socials count as two.'],
]],
[
'key'=>'traditions','name'=>'Traditions Focus T','accent'=>'buzz',
'blurb'=>'Show your passion for Georgia Tech traditions.',
'parts'=>[
	['key'=>'reck8','label'=>'Eight Reck events','need'=>8,'mode'=>'auto',
	 'match'=>['any'=>['ride day','rides','open garage','reck the','t-reck','with the reck','rideout'],'type'=>['work']],
	 'desc'=>'Eight events centred on the Reck itself - ride days, rideouts, open garage time, and appearances with the car.'],
	['key'=>'trad-pres','label'=>'Two Traditions presentations','need'=>2,'mode'=>'auto',
	 'match'=>['any'=>['traditions presentation','trad presentation'],'type'=>['work']],
	 'desc'=>'Give two Traditions presentations, or instead plan and run one Traditions event - internal to the club or for campus. Old Ford Race, Ramblin\' Raft Race and T-Man are the sort of thing.'],
]],
[
'key'=>'work','name'=>'Work Focus T','accent'=>'buzz',
'blurb'=>'Deepen your impact on the work side of the club.',
'parts'=>[
	['key'=>'work12','label'=>'Twelve work events','need'=>12,'mode'=>'auto',
	 'match'=>['type'=>['work'],'not'=>['hoco','homecoming']],
	 'desc'=>'Twelve work events. Homecoming work events are excluded because they belong to the Reck Club Events T, but every other work event counts.'],
]],
]],

'makeup' => ['max'=>5, 'ts'=>[
	['key'=>'bigbuzz','name'=>'Big Buzz Wrangler T','need'=>3,'mode'=>'self',
	 'blurb'=>'Three Big Buzz setups or take-downs',
	 'desc'=>'Assist with three instances of Big Buzz setup or take-down, in any combination.'],
	['key'=>'fundraising','name'=>'Fundraising Friends T','need'=>2,'mode'=>'self',
	 'blurb'=>'Two Wednesday Market tablings, plus a design or 15 scarves',
	 'desc'=>'Table at two Wednesday Market sessions promoting fundraising products, and either get a gameday sticker or button design accepted by the fundraising chair, or sell fifteen scarves.'],
	['key'=>'paparazzi','name'=>'Paparazzi T','need'=>1,'mode'=>'self',
	 'blurb'=>'A video or reel, or an approved flier',
	 'desc'=>'Either make a video, TikTok or Reel for the club socials, or create a flier or graphic about a Tech tradition or club event. Work with Rostan to get it to a standard that can be posted.'],
	['key'=>'copilot','name'=>'Qualified Copilot T','need'=>1,'mode'=>'self',
	 'blurb'=>'Time with the Driver, or ride blocks',
	 'desc'=>'Spend an hour with the Driver on Reck maintenance, co-pilot the Reck for an hour, organise and attend a ride day for another organisation, or run two half-hour ride blocks for friends and faculty.'],
	['key'=>'teamrrc','name'=>'Team RRC Competitor T','need'=>4,'mode'=>'auto',
	 'blurb'=>'Four Team RRC activities','match'=>['any'=>['team rrc']],
	 'desc'=>'Complete four Team RRC activities. These cannot double-count with the four non-mandatory Homecoming events in the Reck Club Events T.'],
	['key'=>'3p','name'=>'3P Thank You T','need'=>1,'mode'=>'self',
	 'blurb'=>'Awarded by the Probate Guides',
	 'desc'=>'Step into a leadership or critical role during the Probate Prank or Project. If you notice a fellow probate carrying more than their share, text Harrison or Katie and they will let that probate know they have earned it.'],
]],

'makeup_covers' => [
	'Reck Club Events T' => 'one missed event',
	'Exec Involvement Star T' => 'one missed star',
	'Athletics Focus T' => 'two non-mandatory sports events',
	'Work Focus T' => 'three work events',
	'Traditions Focus T' => 'two Reck events',
	'Social Focus T' => 'two social events',
	'Friendship Focus T' => 'two hangouts',
],
];
