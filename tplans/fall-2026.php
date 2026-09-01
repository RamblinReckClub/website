<?php
// Fall 2026 Probate T Plan.
// See docs/T-PLAN.md for what every key means and how to write a new semester.

return [
'key'      => 'fall-2026',
'name'     => 'Fall 2026 Probate T Plan',
'start'    => '2026-08-25 00:00:00',
'deadline' => '2026-11-16 12:00:00',

'general' => [
	['key'=>'gen-20',  'label'=>'Complete the 20 non-mandatory event requirement', 'need'=>20, 'mode'=>'auto',
	 'match'=>['type'=>['sports','social','work']]],
	['key'=>'gen-log', 'label'=>'Complete a probate log at the end of the semester', 'need'=>1, 'mode'=>'self'],
	['key'=>'gen-3p',  'label'=>'Participate in the Party, Prank & Project', 'need'=>3, 'mode'=>'self',
	 'hint'=>'Party already complete'],
],

'mandatory' => [
[
'key'=>'reck-events','name'=>'Reck Club Events T',
'blurb'=>'Experience the mandatory events that Reck Club chairs and committees organized.',
'parts'=>[
	['key'=>'hoco4','label'=>'Four non-mandatory Homecoming events','need'=>4,'mode'=>'auto',
	 'match'=>['any'=>['hoco','homecoming','tricycle','team rrc'],'type'=>['work','social','sports']]],
	['key'=>'mini500','label'=>'Work Mini 500','need'=>1,'mode'=>'auto','match'=>['any'=>['mini 500']]],
	['key'=>'cakerace','label'=>'Work Freshman Cake Race','need'=>1,'mode'=>'auto',
	 'match'=>['any'=>['cake race','fcr ']]],
	['key'=>'parade','label'=>'Work Ramblin\' Wreck Parade','need'=>1,'mode'=>'auto',
	 'match'=>['any'=>['wreck parade']]],
	['key'=>'tnight','label'=>'Attend T-Night and work a T-Night duty','need'=>1,'mode'=>'self',
	 'hint'=>'Attendance is auto; the duty is yours to check'],
	['key'=>'fball-games','label'=>'Attend all home football games','need'=>6,'mode'=>'auto',
	 'match'=>['any'=>['football'],'type'=>['mandatory']],
	 'hint'=>'Colorado, UTK, Mercer, Duke, Boston College, Louisville'],
	['key'=>'pregame','label'=>'Complete one pre-game duty','need'=>1,'mode'=>'self',
	 'hint'=>'Assigned by Kaylie'],
	['key'=>'flagduty','label'=>'Complete two Flag (Top/Bottom) duties','need'=>2,'mode'=>'self',
	 'hint'=>'Assigned by Kaylie'],
	['key'=>'fball-prep','label'=>'Six football prep events','need'=>6,'mode'=>'auto',
	 'match'=>['type'=>['work','social']],
	 'buckets'=>[
		'Waffle House' => ['waho','waffle house'],
		'Flag Folding' => ['flag fold'],
		'GTIF'         => ['gtif'],
		'Reck Washing' => ['reck wash'],
	 ],
	 'each_at_least'=>1],
]],
[
'key'=>'exec-star','name'=>'Exec Involvement Star T',
'blurb'=>'Stay involved with exec members\' positions. Complete THREE of the five stars.',
'choose'=>3,
'parts'=>[
	['key'=>'star-di','label'=>'D&I Star','need'=>1,'mode'=>'self',
	 'hint'=>'Lead a club-wide D&I event, or attend two D&I events'],
	['key'=>'star-subchair','label'=>'Sub-Chair Star','need'=>1,'mode'=>'self',
	 'hint'=>'Consistently contribute to a Fall subchair'],
	['key'=>'star-bylaws','label'=>'Bylaws Star','need'=>2,'mode'=>'self',
	 'hint'=>'Two Bylaws Committee meetings'],
	['key'=>'star-merch','label'=>'Merch Star','need'=>1,'mode'=>'self',
	 'hint'=>'Accepted merch design, or buy a MAL merch item'],
	['key'=>'star-im','label'=>'Intramurals Star','need'=>1,'mode'=>'self',
	 'hint'=>'Play 4 intramural games, or support 5'],
]],
[
'key'=>'spirit','name'=>'Spirit & Traditions T',
'blurb'=>'Earn TWO Reckognitions from members.',
'parts'=>[
	['key'=>'reckog','label'=>'Reckognitions received','need'=>2,'mode'=>'self',
	 'hint'=>'Log each one and who granted it'],
]],
[
'key'=>'impact','name'=>'Important Impact T',
'blurb'=>'Make an important impact through a leadership opportunity. Complete ONE.',
'choose'=>1,
'parts'=>[
	['key'=>'imp-social','label'=>'Social Host','need'=>1,'mode'=>'self','hint'=>'12+ probates/members'],
	['key'=>'imp-launch','label'=>'Initiative Launch','need'=>1,'mode'=>'self'],
	['key'=>'imp-passion','label'=>'Passion Project','need'=>1,'mode'=>'self'],
	['key'=>'imp-subchair','label'=>'Sub-Chair Expansion','need'=>1,'mode'=>'self','hint'=>'Needs Chair/Guide approval'],
]],
],

'elective' => ['need'=>3, 'ts'=>[
[
'key'=>'athletics','name'=>'Athletics Focus T',
'blurb'=>'Attend SIX non-mandatory sporting events.',
'parts'=>[
	['key'=>'ath6','label'=>'Non-mandatory sporting events','need'=>6,'mode'=>'auto',
	 'match'=>['type'=>['sports']]],
]],
[
'key'=>'friendship','name'=>'Friendship Focus T',
'blurb'=>'EIGHT distinct 1-on-1 hangouts with members. At most three with your own RP.',
'parts'=>[
	['key'=>'hangouts','label'=>'Distinct hangouts logged','need'=>8,'mode'=>'self',
	 'hint'=>'One per member; max three with your RP'],
]],
[
'key'=>'social','name'=>'Social Focus T',
'blurb'=>'Attend FIFTEEN social events, at least SEVEN non-PMS.',
'parts'=>[
	['key'=>'soc15','label'=>'Social events','need'=>15,'mode'=>'auto','match'=>['type'=>['social']]],
	['key'=>'soc-nonpms','label'=>'of which non-PMS','need'=>7,'mode'=>'auto',
	 'match'=>['type'=>['social'],'not'=>['pms']]],
]],
[
'key'=>'traditions','name'=>'Traditions Focus T',
'blurb'=>'EIGHT Reck events, plus two Traditions presentations or one Traditions event.',
'parts'=>[
	['key'=>'reck8','label'=>'Reck events','need'=>8,'mode'=>'auto',
	 'match'=>['any'=>['ride day','rides','open garage','reck the','t-reck','with the reck','rideout'],'type'=>['work']]],
	['key'=>'trad-pres','label'=>'Two Traditions presentations, or plan one Traditions event','need'=>2,'mode'=>'auto',
	 'match'=>['any'=>['traditions presentation','trad presentation'],'type'=>['work']]],
]],
[
'key'=>'work','name'=>'Work Focus T',
'blurb'=>'Complete TWELVE work events, excluding Homecoming work events.',
'parts'=>[
	['key'=>'work12','label'=>'Work events','need'=>12,'mode'=>'auto',
	 'match'=>['type'=>['work'],'not'=>['hoco','homecoming']]],
]],
]],

'makeup' => ['max'=>5, 'ts'=>[
	['key'=>'bigbuzz','name'=>'Big Buzz Wrangler T','need'=>3,'mode'=>'self',
	 'blurb'=>'Three Big Buzz setups or take-downs'],
	['key'=>'fundraising','name'=>'Fundraising Friends T','need'=>2,'mode'=>'self',
	 'blurb'=>'Two Wednesday Market tablings, plus a design or 15 scarves'],
	['key'=>'paparazzi','name'=>'Paparazzi T','need'=>1,'mode'=>'self',
	 'blurb'=>'A video/reel, or an approved flier'],
	['key'=>'copilot','name'=>'Qualified Copilot T','need'=>1,'mode'=>'self',
	 'blurb'=>'Reck maintenance hour, co-pilot, ride day, or two ride blocks'],
	['key'=>'teamrrc','name'=>'Team RRC Competitor T','need'=>4,'mode'=>'auto',
	 'blurb'=>'Four Team RRC activities','match'=>['any'=>['team rrc']]],
	['key'=>'3p','name'=>'3P Thank You T','need'=>1,'mode'=>'self',
	 'blurb'=>'Awarded by the Probate Guides'],
]],
];
