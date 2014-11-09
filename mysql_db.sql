
CREATE TABLE Location
(
	LocationID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Latitude double NOT NULL,
	Longitude double NOT NULL,
	#indoor/outdoor
	Type char NOT NULL, 
	Comment varchar(100)
);

CREATE TABLE Device
(
	DeviceID int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	LocationID int NOT NULL,
	CONSTRAINT fk_locationID FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
);

CREATE TABLE SensorType
(
	TypeID char NOT NULL PRIMARY KEY, 
	#eg. for temp. C\F 
	Unit varchar(5) NOT NULL
);

CREATE TABLE SensorSpec
(
	SpecID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	#eg.dht11
	Model varchar(20) NOT NULL,
	TypeID char NOT NULL,	
	Accuracy float NOT NULL,
	Minimum float,
	Maximum float,
	CONSTRAINT fk_TypeID FOREIGN KEY (TypeID) REFERENCES SensorType(TypeID)	
);

CREATE TABLE Sensor
(
	SensorID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	DeviceID int NOT NULL,
	SpecID int NOT NULL,
	CONSTRAINT fk_DeviceID FOREIGN KEY (DeviceID) REFERENCES Device(DeviceID),
	CONSTRAINT fk_SpecID FOREIGN KEY (SpecID) REFERENCES SensorSpec(SpecID)	
);

CREATE TABLE Reading
(
	ReadingID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Time int NOT NULL, 
	Value int NOT NULL,
	SensorID int NOT NULL, #add constrain to sensor spec table
	LocationID int NOT NULL,
	CONSTRAINT fk_SensorID FOREIGN KEY (SensorID) REFERENCES Sensor(SensorID),
	CONSTRAINT fk_ReadingsLocationID FOREIGN KEY (LocationID) REFERENCES Location(LocationID)	
);
