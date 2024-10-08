-- TABLE_ZIPCODES: Store data about specific zipcodes
CREATE TABLE ZIPCODE (
  Zipcode INT NOT NULL,
  City VARCHAR(255) NOT NULL,
  PRIMARY KEY (Zipcode)
);

-- TABLE_USERS: Store data about users
CREATE TABLE USER (
  Username VARCHAR(30) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  UserEmail VARCHAR(255) NOT NULL UNIQUE,
  HomeAddress INT NOT NULL,
  UserType VARCHAR(255) NOT NULL,
  PRIMARY KEY (Username),
  FOREIGN KEY (HomeAddress) REFERENCES ZIPCODE(Zipcode)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);


-- TABLE_CITY_LOOK_UP: store data about countys in a city
CREATE TABLE CITY_LOOK_UP (
  City VARCHAR(255) NOT NULL,
  County VARCHAR(255) NOT NULL,
  PRIMARY KEY (City)
);


-- TABLE_INCIDENTS: Store data about incidents
CREATE TABLE INCIDENT (
  IncidentID INT NOT NULL,
  IncidentLocation INT NOT NULL,
  InStartTimeAndDate DATETIME NOT NULL,
  InEndTimeDate DATETIME NOT NULL,
  IncType VARCHAR(255) NOT NULL,
  TimeDelay INT NOT NULL , 
  PRIMARY KEY (IncidentID),
  FOREIGN KEY (IncidentLocation) REFERENCES ZIPCODE(Zipcode)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);

-- TABLE_ORGANIZERS: Store data about organizers that run the events
CREATE TABLE ORGANIZER (
  OrgID INT NOT NULL,
  OrgName VARCHAR(255) NOT NULL,
  OrgEmail VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY (OrgID)
);

-- TABLE_EVENTS: Store data about events happening in different areas
CREATE TABLE EVENT (
  EventID INT NOT NULL,
  EventLocation INT NOT NULL,
  EventName VARCHAR(255) NOT NULL,
  EvStartTimeAndDate DATETIME NOT NULL,
  EvEndTimeAndDate DATETIME NOT NULL,
  EventType VARCHAR(255) NOT NULL,
  Size VARCHAR(255) NOT NULL,
  OrganizerID INT NOT NULL,
  PRIMARY KEY (EventID),
  FOREIGN KEY (OrganizerID) REFERENCES ORGANIZER(OrgID)
    ON DELETE CASCADE ON UPDATE RESTRICT, 
  FOREIGN KEY (EventLocation) REFERENCES ZIPCODE(Zipcode)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);

-- TABLE_ROUTES: Store data about routes
CREATE TABLE ROUTE (
  RouteID INT NOT NULL,
  UserName VARCHAR(30) NOT NULL,
  StartingZipcode INT NOT NULL,
  EndingZipcode INT NOT NULL,
  StartTime DATETIME NOT NULL,
  EndTime DATETIME NOT NULL,
  PRIMARY KEY (RouteID),
  FOREIGN KEY (UserName) REFERENCES USER(Username)
    ON DELETE CASCADE ON UPDATE RESTRICT, 
  FOREIGN KEY (StartingZipcode) REFERENCES ZIPCODE(Zipcode)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
  FOREIGN KEY (EndingZipcode) REFERENCES ZIPCODE(Zipcode)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);

-- adding final fk constraint for zipcodes city
ALTER TABLE ZIPCODE ADD CONSTRAINT city_fk FOREIGN KEY (City) REFERENCES CITY_LOOK_UP(City);

-- 4 CHECK CONSTRAINTS
ALTER TABLE INCIDENT ADD CHECK (TimeDelay > 0);
ALTER TABLE ZIPCODE  ADD CHECK (Zipcode>=10000 AND Zipcode<=99999); -- keep to 5 integers
ALTER TABLE EVENT  ADD CHECK (EvStartTimeAndDate<EvEndTimeAndDate);
ALTER TABLE ROUTE  ADD CHECK (StartTime<EndTime);


-- FOUR attributes with Default values
ALTER TABLE USER ALTER UserType SET DEFAULT 'normal'; 
ALTER TABLE USER ALTER HomeAddress SET DEFAULT 98404; -- tacoma zipcode
ALTER TABLE EVENT ALTER Size SET DEFAULT 'small';
ALTER TABLE INCIDENT ALTER IncType SET DEFAULT 'incident'; -- generic incident name

-- Sample Data for CITY_LOOK_UP
INSERT INTO CITY_LOOK_UP (City, County) VALUES
('Belfair', 'Mason County'),
('Bonney Lake', 'Pierce County'),
('Burley', 'Kitsap County'),
('Carbonado', 'Pierce County'),
('Carlsborg', 'Clallam County'),
('Chimacum', 'Jefferson County'),
('Clallam Bay', 'Clallam County'),
('Dupont', 'Pierce County'),
('Eatonville', 'Pierce County'),
('Gig Harbor', 'Pierce County');

-- Sample Data for ZIPCODE
INSERT INTO ZIPCODE (Zipcode, City) VALUES
(98320, 'Belfair'),
(98321, 'Bonney Lake'),
(98322, 'Burley'),
(98323, 'Carbonado'),
(98324, 'Carlsborg'),
(98325, 'Chimacum'),
(98326, 'Clallam Bay'),
(98327, 'Dupont'),
(98328, 'Eatonville'),
(98329, 'Gig Harbor');

-- Sample Data for USER
INSERT INTO USER (Username, Password, UserEmail, HomeAddress, UserType) VALUES
('johnDoe', 'pwd123', 'john.doe@email.com', 98320, 'normal'),
('janeSmith', 'pass456', 'jane.smith@email.com', 98321, 'normal'),
('mikeBrown', 'mike789', 'mike.brown@email.com', 98322, 'premium'),
('lisaWhite', 'lisa321', 'lisa.white@email.com', 98323, 'normal'),
('tomGreen', 'tom654', 'tom.green@email.com', 98324, 'premium'),
('sarahHall', 'hall987', 'sarah.hall@email.com', 98325, 'normal'),
('chrisLee', 'lee1234', 'chris.lee@email.com', 98326, 'normal'),
('emmaClark', 'clark4321', 'emma.clark@email.com', 98327, 'normal'),
('davidLewis', 'david567', 'david.lewis@email.com', 98328, 'normal'),
('oliviaJones', 'olivia890', 'olivia.jones@email.com', 98329, 'normal');


-- Sample Data for INCIDENT
INSERT INTO INCIDENT (IncidentID, IncidentLocation, InStartTimeAndDate, InEndTimeDate, IncType, TimeDelay) VALUES
(1, 98320, '2023-12-05 08:00:00', '2023-12-05 09:30:00', 'accident', 30),
(2, 98321, '2023-12-04 10:00:00', '2023-12-04 11:30:00', 'weather', 60),
(3, 98322, '2023-12-03 14:00:00', '2023-12-03 15:30:00', 'traffic jam', 90),
(4, 98323, '2023-12-02 17:00:00', '2023-12-02 18:30:00', 'construction', 40),
(5, 98324, '2023-12-01 12:00:00', '2023-12-01 13:30:00', 'accident', 50),
(6, 98325, '2023-11-30 09:00:00', '2023-11-30 10:30:00', 'weather', 30),
(7, 98326, '2023-11-29 15:00:00', '2023-11-29 16:30:00', 'traffic jam', 45),
(8, 98327, '2023-11-28 18:00:00', '2023-11-28 19:30:00', 'construction', 30),
(9, 98328, '2023-11-27 11:00:00', '2023-11-27 12:30:00', 'accident', 60),
(10, 98329, '2023-11-26 13:00:00', '2023-11-26 14:30:00', 'weather', 30);

-- Sample Data for ORGANIZER
INSERT INTO ORGANIZER (OrgID, OrgName, OrgEmail) VALUES
(1, 'Sunset Events', 'contact@sunsetevents.com'),
(2, 'Harbor Festivals', 'info@harborfest.com'),
(3, 'Mountain Music', 'music@mountain.com'),
(4, 'City Lights Entertainment', 'info@citylightsent.com'),
(5, 'Green Field Events', 'contact@greenfieldevents.com'),
(6, 'Blue Sky Organizers', 'info@blueskyorg.com'),
(7, 'Riverfront Gatherings', 'contact@riverfront.com'),
(8, 'Lakeside Celebrations', 'info@lakesideceleb.com'),
(9, 'Urban Beats', 'contact@urbanbeats.com'),
(10, 'Starlight Productions', 'info@starlightprod.com');

-- Sample Data for EVENT
INSERT INTO EVENT (EventID, EventLocation, EventName, EvStartTimeAndDate, EvEndTimeAndDate, EventType, Size, OrganizerID) VALUES
(1, 98320, 'Belfair Music Fest', '2023-12-10 15:00:00', '2023-12-10 22:00:00', 'concert', 'medium', 1),
(2, 98321, 'Bonney Lake Art Fair', '2023-12-11 10:00:00', '2023-12-11 18:00:00', 'festival', 'large', 2),
(3, 98322, 'Burley Food Carnival', '2023-12-12 12:00:00', '2023-12-12 20:00:00', 'carnival', 'small', 3),
(4, 98323, 'Carbonado Holiday Market', '2023-12-13 09:00:00', '2023-12-13 17:00:00', 'market', 'medium', 4),
(5, 98324, 'Carlsborg Jazz Night', '2023-12-14 18:00:00', '2023-12-14 23:00:00', 'concert', 'small', 5),
(6, 98325, 'Chimacum Comedy Show', '2023-12-15 20:00:00', '2023-12-15 22:00:00', 'comedy show', 'small', 6),
(7, 98326, 'Clallam Bay Movie Night', '2023-12-16 19:00:00', '2023-12-16 23:00:00', 'movie night', 'medium', 7),
(8, 98327, 'Dupont Craft Expo', '2023-12-17 10:00:00', '2023-12-17 18:00:00', 'expo', 'large', 8),
(9, 98328, 'Eatonville Sports Day', '2023-12-18 09:00:00', '2023-12-18 16:00:00', 'sports event', 'large', 9),
(10, 98329, 'Gig Harbor Food Festival', '2023-12-19 11:00:00', '2023-12-19 21:00:00', 'festival', 'medium', 10);

-- Sample Data for ROUTE
INSERT INTO ROUTE (RouteID, UserName, StartingZipcode, EndingZipcode, StartTime, EndTime) VALUES
(1, 'johnDoe', 98320, 98321, '2023-12-05 08:00:00', '2023-12-05 08:30:00'),
(2, 'janeSmith', 98321, 98324, '2023-12-04 09:00:00', '2023-12-04 12:00:00'),
(3, 'mikeBrown', 98322, 98325, '2023-12-03 10:00:00', '2023-12-03 11:30:00'),
(4, 'lisaWhite', 98323, 98326, '2023-12-02 14:00:00', '2023-12-02 16:30:00'),
(5, 'tomGreen', 98324, 98327, '2023-12-01 15:00:00', '2023-12-01 17:30:00'),
(6, 'sarahHall', 98325, 98328, '2023-11-30 08:00:00', '2023-11-30 10:30:00'),
(7, 'chrisLee', 98326, 98329, '2023-11-29 13:00:00', '2023-11-29 16:30:00'),
(8, 'emmaClark', 98327, 98320, '2023-11-28 07:00:00', '2023-11-28 10:00:00'),
(9, 'davidLewis', 98328, 98321, '2023-11-27 09:00:00', '2023-11-27 12:30:00'),
(10, 'oliviaJones', 98329, 98322, '2023-11-26 15:00:00', '2023-11-26 18:30:00');


-- sql queries

-- QUERY #1
-- Admin query
-- SQL query to find out the total distance traveled by users per city
SELECT Z.City AS 'City', COUNT(U.Username) AS 'Number of Users', SUM((ABS(R.EndingZipcode - R.StartingZipcode))*35) AS 'Total Distance Traveled'
                                            FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                            JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                            GROUP BY Z.City
                                            ORDER BY SUM((ABS(R.EndingZipcode - R.StartingZipcode))*35); 

-- QUERY #2
-- Admin query
-- Runs a SQL query to find how far users are commuting in a specific county(Gig Harbor in this case)
SELECT U.Username, (ABS(R.EndingZipcode - R.StartingZipcode))*35 AS 'Distance'
                                            FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                            JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                            JOIN CITY_LOOK_UP CLU ON Z.City = CLU.City
                                            WHERE CLU.County = 'Pierce County';
                                            
-- QUERY #3
-- Admin query
-- SQL query to find what routes users are taking who live in a specific city(Belfair in this case)
SELECT U.Username, R.StartingZipcode AS 'Starting Point', R.EndingZipcode AS 'Destination'
                                        FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                        JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                        JOIN CITY_LOOK_UP CLU ON Z.City = CLU.City
                                        WHERE CLU.City = 'Belfair'; 
                                            
-- QUERY #4
-- Standard User Query
-- SQL query to display all events and info about them including the organizer
SELECT EventName, OrgName, EventLocation, DATE(EvStartTimeAndDate) AS 'Date', TIME(EvStartTimeAndDate) AS 'EventSTime', TIME(EvEndTimeAndDate) AS 'EventETime', EventType
FROM EVENT E JOIN ORGANIZER O ON E.OrganizerID = O.OrgID;    
                                            
-- QUERY #5
-- Standard User Query
-- Runs a SQL query to find event data based on date
SELECT EventName, TIME(EvStartTimeAndDate) AS EventSTime, TIME(EvEndTimeAndDate) AS EventETime, EventType, Z.City AS ZCity, County
FROM (EVENT E JOIN ZIPCODE Z ON E.EventLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
WHERE DATE(EvStartTimeAndDate) = '2023-12-10';  

-- QUERY #6
-- Standard User Query
-- SQL query to find event data based on start time
SELECT EventName, DATE(EvStartTimeAndDate) AS Date, TIME(EvStartTimeAndDate) AS EventSTime, TIME(EvEndTimeAndDate) AS EventETime, EventType, Z.City AS ZCity, County
FROM (EVENT E JOIN ZIPCODE Z ON E.EventLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
WHERE TIME(EvStartTimeAndDate) = '12:00:00';
                            
-- QUERY #7
-- Standard User Query
-- SQL query to find event data based on zipcode
SELECT EventName, DATE(EvStartTimeAndDate) AS Date, TIME(EvStartTimeAndDate) AS EventSTime, TIME(EvEndTimeAndDate) AS EventETime, EventType, Z.City AS ZCity, County
FROM (EVENT E JOIN ZIPCODE Z ON E.EventLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
WHERE E.EventLocation = 98320;
     
-- QUERY #8
-- Standard User Query
-- SQL query to find event data based on event type 
SELECT EventName, DATE(EvStartTimeAndDate) AS Date, TIME(EvStartTimeAndDate) AS EventSTime, TIME(EvEndTimeAndDate) AS EventETime, EventLocation, Z.City AS ZCity, County
FROM (EVENT E JOIN ZIPCODE Z ON E.EventLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
WHERE E.EventType = 'comedy show';
                            
-- QUERY #9
-- Standard User Query
-- sql query to find incidents on a Route
SELECT IncType, TimeDelay
FROM INCIDENT I
WHERE I.IncidentLocation = 98320;

-- QUERY #10
-- Standard User Query
-- sql query to find incidents by type
SELECT IncType, IncidentLocation, Z.City AS ZCity, County
FROM (INCIDENT I JOIN ZIPCODE Z ON I.IncidentLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
WHERE I.IncType = 'weather';
