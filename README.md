# Facebook-ban-bypass
A small project made to bypass the Facebook ban on news in Canada.
It looks like it's straight out of 1992... it sets an iframe to show content despite the ban, allows to share it and to go to the actual page it's from.
# MySQL database
In order for all of this to work you have to create a a MySQL database. It needs 4 fields named Time stamp (this one is rather useless for now) this is a datetime field, URL as text in utf8mb4 unicode 520, Title also text utf8mb4 unicode 520 and ID. obviously you beed to set password username and all in the PHP
# future
next step is the creation of a moderation tool un order to be able to edit submitted content without having to go to the database every time.
