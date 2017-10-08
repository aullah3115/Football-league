
--------------------------------------------------------------
-- Database creation Script

-- Auto-Generated by QSEE-SuperLite (c) 2001-2004 QSEE-Technologies Ltd.

-- Verbose generation: ON

-- note: spaces within table/column names have been replaced by underscores (_)

-- Target DB: SQL2

-- Entity Model :Entity Relationship Diagram

-- To drop the tables generated by this script run -
--   'C:\xampp\htdocs\Football\database_drop.sql'

--------------------------------------------------------------



--------------------------------------------------------------
-- Table Creation --

-- Each entity on the model is represented by a table that needs to be created within the Database.
-- Within SQL new tables are created using the CREATE TABLE command.
-- When a table is created its name and its attributes are defined.
-- The values of which are derived from those specified on the model.
-- Certain constraints are sometimes also specified, such as identification of primary keys.

-- Create a Database table to represent the "User" entity.
CREATE TABLE User(
	user_id	INTEGER NOT NULL,
	user_name	VARCHAR(30),
	password	VARCHAR(20),
	email	VARCHAR(50) UNIQUE,
	-- Specify the PRIMARY KEY constraint for table "User".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_User PRIMARY KEY (user_id)
);

-- Create a Database table to represent the "leagues" entity.
CREATE TABLE leagues(
	league_id	INTEGER NOT NULL,
	league_name	VARCHAR(50),
	user_id	INTEGER,
	fk1_user_id	INTEGER NOT NULL,
	-- Specify the PRIMARY KEY constraint for table "leagues".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_leagues PRIMARY KEY (league_id)
);

-- Create a Database table to represent the "teams" entity.
CREATE TABLE teams(
	team_id	INTEGER NOT NULL,
	league_id	INTEGER,
	team_name	VARCHAR(30),
	fk1_league_id	INTEGER NOT NULL,
	-- Specify the PRIMARY KEY constraint for table "teams".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_teams PRIMARY KEY (team_id)
);

-- Create a Database table to represent the "players" entity.
CREATE TABLE players(
	player_id	INTEGER NOT NULL,
	team_id	INTEGER,
	player_name	VARCHAR(50),
	fk1_team_id	INTEGER NOT NULL,
	-- Specify the PRIMARY KEY constraint for table "players".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_players PRIMARY KEY (player_id)
);

-- Create a Database table to represent the "matches" entity.
CREATE TABLE matches(
	match_id	INTEGER NOT NULL,
	team1	INTEGER,
	team2	INTEGER,
	week	DATE,
	round	INTEGER,
	fk1_team_id	INTEGER NOT NULL,
	-- Specify the PRIMARY KEY constraint for table "matches".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_matches PRIMARY KEY (match_id)
);

-- Create a Database table to represent the "match_events" entity.
CREATE TABLE match_events(
	match_id	INTEGER NOT NULL,
	player_id	INTEGER,
	time_of_occurrence	TIME(8),
	event_id	INTEGER,
	fk1_match_id	INTEGER NOT NULL,
	fk2_player_id	INTEGER NOT NULL,
	fk3_event_id	INTEGER NOT NULL,
	-- Specify the PRIMARY KEY constraint for table "match_events".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_match_events PRIMARY KEY (match_id)
);

-- Create a Database table to represent the "events" entity.
CREATE TABLE events(
	event_id	INTEGER NOT NULL,
	event_name	INTEGER,
	-- Specify the PRIMARY KEY constraint for table "events".
	-- This indicates which attribute(s) uniquely identify each row of data.
	CONSTRAINT	pk_events PRIMARY KEY (event_id)
);


--------------------------------------------------------------
-- Alter Tables to add fk constraints --

-- Now all the tables have been created the ALTER TABLE command is used to define some additional
-- constraints.  These typically constrain values of foreign keys to be associated in some way
-- with the primary keys of related tables.  Foreign key constraints can actually be specified
-- when each table is created, but doing so can lead to dependency problems within the script
-- i.e. tables may be referenced before they have been created.  This method is therefore safer.

-- Alter table to add new constraints required to implement the "leagues_User" relationship

-- This constraint ensures that the foreign key of table "leagues"
-- correctly references the primary key of table "User"

ALTER TABLE leagues ADD CONSTRAINT fk1_leagues_to_User FOREIGN KEY(fk1_user_id) REFERENCES User(user_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "teams_leagues" relationship

-- This constraint ensures that the foreign key of table "teams"
-- correctly references the primary key of table "leagues"

ALTER TABLE teams ADD CONSTRAINT fk1_teams_to_leagues FOREIGN KEY(fk1_league_id) REFERENCES leagues(league_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "players_teams" relationship

-- This constraint ensures that the foreign key of table "players"
-- correctly references the primary key of table "teams"

ALTER TABLE players ADD CONSTRAINT fk1_players_to_teams FOREIGN KEY(fk1_team_id) REFERENCES teams(team_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "matches_teams" relationship

-- This constraint ensures that the foreign key of table "matches"
-- correctly references the primary key of table "teams"

ALTER TABLE matches ADD CONSTRAINT fk1_matches_to_teams FOREIGN KEY(fk1_team_id) REFERENCES teams(team_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "match_events_matches" relationship

-- This constraint ensures that the foreign key of table "match_events"
-- correctly references the primary key of table "matches"

ALTER TABLE match_events ADD CONSTRAINT fk1_match_events_to_matches FOREIGN KEY(fk1_match_id) REFERENCES matches(match_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "match_events_players" relationship

-- This constraint ensures that the foreign key of table "match_events"
-- correctly references the primary key of table "players"

ALTER TABLE match_events ADD CONSTRAINT fk2_match_events_to_players FOREIGN KEY(fk2_player_id) REFERENCES players(player_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Alter table to add new constraints required to implement the "match_events_events" relationship

-- This constraint ensures that the foreign key of table "match_events"
-- correctly references the primary key of table "events"

ALTER TABLE match_events ADD CONSTRAINT fk3_match_events_to_events FOREIGN KEY(fk3_event_id) REFERENCES events(event_id) ON DELETE RESTRICT ON UPDATE RESTRICT;


--------------------------------------------------------------
-- End of DDL file auto-generation
--------------------------------------------------------------