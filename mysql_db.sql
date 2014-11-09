
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
#first letter of the sensore type
Symbol char NOT NULL PRIMARY KEY, 
#eg. for temp. C\F 
Unit varchar(5) NOT NULL
);

#updated to include range of readings
CREATE TABLE Sensor
(
DeviceID int NOT NULL,
TypeSymbol char NOT NULL,
#eg.dht11
Model varchar(20) NOT NULL,
Accuracy float NOT NULL,
Maximum float,
Minimum float,
CONSTRAINT fk_SensorDeviceID FOREIGN KEY (DeviceID) REFERENCES Device(DeviceID),
CONSTRAINT fk_SensorID FOREIGN KEY (TypeSymbol) REFERENCES SensorType(Symbol),
CONSTRAINT pk_SensorID PRIMARY KEY (DeviceID,TypeSymbol)
);


CREATE TABLE Reading
(
ReadingID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
Time int NOT NULL, 
DeviceID int NOT NULL,
Value int NOT NULL,
SensorTypeSymbol char NOT NULL, 
LocationID int NOT NULL,
CONSTRAINT fk_DeviceID FOREIGN KEY (DeviceID) REFERENCES Device(DeviceID),
CONSTRAINT fk_ReadingsSensorID FOREIGN KEY (DeviceID, SensorTypeSymbol) REFERENCES Sensor(DeviceID,TypeSymbol),
CONSTRAINT fk_ReadingsLocationID FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
);
